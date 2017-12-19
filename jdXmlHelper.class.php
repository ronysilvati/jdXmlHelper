<?php
//**************************************************************************//
//    JdXmlHelper -- Classe auxiliar para a manipulação de xml              //
//**************************************************************************//
##############################################################################
## Jetdata Sistemas, setembro de 2016
## Desenvolvedor: Rony Silva (ronysilvati@live.com)
##############################################################################
//////////////////////////////////////////////////////////////////////////////

##############################################################################

class JdXmlHelper {

    public function __constructor(){

    }

    /**
     * @param null $array
     * @param null $root
     * @throws Exception
     * =================================================
     * Efetua a chamada do método responsável pela
     * conversão de um array em XML.
     * =================================================
     */
    public function arrayToXML($array=null,$root = null){
        return $this->__arrayToXML($array,$root);
    }

    /**
     * @param $data
     * @param null $root
     * @throws Exception
     * ================================================
     * Efetua a conversão de um array em XML, o método
     * leva em conta a recursividade de um array,
     * retornando assim, toda recursividade como um nó
     * do tipo "linha"
     * ================================================
     *
     */
    private function __arrayToXML($data,$root = null){
        if(is_array($data)){
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'.($root ? '<' . $root . '/>' : '<root/>'));
            $xml[0]->addChild('dados');

            foreach($data as $key=>$value){
                if(is_array($value)){
                    $this->__arrayToXMLRecursion($xml[0]->dados,$key,$value);
                }
                else{
                    $xml[0]->dados->addChild($key, $value);
                }
            }

            return $xml;
        }
        else{
            throw new Exception("Um array válido não foi informado");
        }

    }

    /**
     * @param $xmlOriginWithoutNode
     * @param $parent
     * @param $arrayNodes
     * ===============================================================================
     * Efetua conversão da recursividade de um array em nós xml seguindo praticamente
     * a mesma estrutura do array (Com exceção das chaves que passam a ser "linha"
     * ===============================================================================
     */
    private function __arrayToXMLRecursion($xmlOriginWithoutNode,$parent,$arrayNodes){
        if(!is_int($parent)){
            $newFragmentXml = $xmlOriginWithoutNode->addChild($parent);
        }
        else{
            $newFragmentXml = $xmlOriginWithoutNode->addChild('linha');
        }

        foreach($arrayNodes as $key=>$node){
            if(is_array($node)){
                $this->__arrayToXMLRecursion($newFragmentXml,$key,$node);
            }
            else{
                $newFragmentXml->addChild($key,$node);
            }
        }
    }
}