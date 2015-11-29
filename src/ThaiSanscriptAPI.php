<?php

namespace ThaiSanskrit;

use ThaiSanskrit\ThaiSanscriptRule;

class ThaiSanscriptAPI {

    public function __construct() {
        
    }

    public function transliteration($romanize) {
        mb_internal_encoding("UTF-8");
        $listLine = preg_split('/\r\n|\r|\n/', $txt);
        $listLineThai = array();
        print_r($listLine);
        foreach ($listLine as $line) {

            $line = mb_strtolower($line, "UTF-8");
            $syllableThai = explode(" ", $line);
            $syllableRoman = explode(" ", $line);

            $builderThai = "";
            $builderRoman = "";
            for ($i = 0; $i < count($syllableThai); $i++) {
                $syllableThai[$i] = ThaiSanscriptRule::convert($syllableThai[$i]);
                $builderThai .= $syllableThai[$i];
                $builderThai .= " ";
                $builderRoman .= $syllableRoman[$i];
                $builderRoman .= " ";
            }

            $listLineThai[] = $builderThai . "\n";
            $listLineThai[] = $builderRoman . "\n";
//            listLineThai.add(builderRoman.toString());
//            listLineThai.add("\n");
        }
        return Util::convertListTostring($listLineThai);
//        echo Util::convertListTostring($listLine);
    }

    public function transliterationTracking($romanize) {
        return ThaiSanscriptRule::convert($romanize, TRUE);
    }

    public function transliterationToArray($romanize, $devanagari) {
        mb_internal_encoding("UTF-8");
        $returnArray = array();
        $listRomanize = preg_split('/\r\n|\r|\n/', $romanize);

        foreach ($listRomanize as $key => $line) {

            $line = mb_strtolower($line, "UTF-8");
            $syllableThai = explode(" ", $line);
            $syllableRomanize = explode(" ", $line);

            for ($i = 0; $i < count($syllableThai); $i++) {
                $syllableThai[$i] = ThaiSanscriptRule::convert($syllableThai[$i]);
            }
            $returnArray['thai'][$key] = $syllableThai;
            $returnArray['romanize'][$key] = $syllableRomanize;
        }
        if (trim($devanagari) != "") {
            $listDevanagari = preg_split('/\r\n|\r|\n/', $devanagari);
            foreach ($listDevanagari as $key => $line) {
                $syllableDevanagari = explode(" ", $line);
                $returnArray['devanagari'][$key] = $syllableDevanagari;
            }
        }
        return $returnArray;
    }

}
