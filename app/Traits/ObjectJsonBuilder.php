<?php
namespace App\Traits;

trait ObjectJsonBuilder {

    public function getHiddenAttributes() {
        return isset(get_class($this)::$hiddenColumnForApi) ? get_class($this)::$hiddenColumnForApi : null;
    }

    public function getAppendAttributes() {
        return isset(get_class($this)::$appendsForApi) ? get_class($this)::$appendsForApi : null;
    }

    public function getRelationships(){
        return isset(get_class($this)::$includeRelationshipsForApi) ? get_class($this)::$includeRelationshipsForApi : [];
    }

    public function toArrayForApi(){
        if($this->getAppendAttributes())
            $this->setAppends($this->getAppendAttributes());
        if($this->getHiddenAttributes())
            $this->setHidden($this->getHiddenAttributes());
        $data = $this->toArray();

        foreach ($this->getRelationships() as $aliasName => $relationship){
            if($relationship == str_singular($relationship)){
                $relationship_data=null;
                if(method_exists($this->$relationship,'toArrayForApi'))
                    $relationship_data = $this->$relationship->toArrayForApi();

            }else{
                $relationship_data = [];
                foreach(eval("return \$this->$relationship;") as $relationship_collection){
                    if(method_exists($relationship_collection,'toArrayForApi'))
                        array_push($relationship_data, $relationship_collection->toArrayForApi());
                }
            }
            $data[snake_case(gettype($aliasName) == 'string' ? $aliasName : $relationship)] = $relationship_data;
        }
        return $data;
    }

    public function toJsonForApi(){
        return json_encode($this->toArrayForApi());
    }
}