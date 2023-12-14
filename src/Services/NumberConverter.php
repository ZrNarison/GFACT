<?php

namespace App\Service;

class NumberConverter
{   
    private $chiffre;
    private $dizaine;
    public function __construct()
        {
            $this->chiffre = [
                1 => "un",
                2 => "deux",
                3 => "trois",
                4 => "quatre",
                5 => "cinq",
                6 => "six",
                7 => "sept",
                8 => "huit",
                9 => "neuf",
                10 => "dix",
                11 => "onze",
                12 => "douze",
                13 => "treize",
                14 => "quatorze",
                15 => "quinze",
                16 => "seize",
                17 => "dix-sept",
                18 => "dix-huit",
                19 => "dix-neuf"
            ];

            $this->dizaine = [
                1 => "dix",
                2 => "vingt",
                3 => "trente",
                4 => "quarante",
                5 => "cinquante",
                6 => "soixante",
                8 => "quatre-vingt"
            ];
        }
    
    public function ConvertNbLettres($nb) 
    {
        $varnum = 0;
        $varnumD = 0;
        $varnumU = 0;
        $resultat = "";
        $varlet = "";

        

        // traitement du cas 0
        if ($nb >= 1) {
            $resultat = "" . "";
        } else {
            $resultat = "zéro";
            goto fintraitementfrancs;
        }

        // traitement des milliard 000000
        $varnum = (int)($nb / 1000000000);
        $varnum = (int)($varnum / 1000000);
        if ($varnum > 0) {
            $this->centaineDizaine($varlet, $varnum, $resultat);
            $resultat .= " milliard "; 
            if ($varlet !== "un") {
                $resultat = $varlet; 
            }
            $resultat = $resultat ." milliard";
        }

        // traitement des millions
        $varnum = (int)($nb / 1000000);
        if ($varnum > 0) {
            $this->centaineDizaine($varlet, $varnum, $resultat);
            $resultat .= " millions "; 
            if ($varlet !== "un") {
                $resultat = $varlet; 
            }
            $resultat = $resultat ." millions ";
        }


        // Traitement des milliers
        $varnum = (int)($nb % 1000000);
        $varnum = (int)($varnum / 1000);
        if ($varnum > 0) {
            $this->centaineDizaine($varlet, $varnum, $resultat);
            if ($varlet !== " un ") {
                $resultat = $varlet; 
            }

            $resultat = $resultat ." mille ".$this->centaineDizaine($varlet, $varnum, $resultat);
        }

        // traitement des centaines et dizaines
        $varnum = (int)($nb % 1000);
        $varnum = (int)(($nb - (int)$nb) * 100 + 0.5);
        if ($varnum > 0) {
            $this->centaineDizaine($varlet, $varnum, $resultat);
            $resultat .= $varlet;
            if ($varnum > 1) {
                $resultat .= " ";
            }
        $resultat = ltrim($resultat);
        $varlet = substr($resultat, -4);
        }
        

        // traitement du "s" final pour vingt et cent et du "de" pour million
        switch ($varlet) {
            case "cent":
            case "ingt":
                $resultat = $resultat . " ";
                break;
            case "lion":
            case "ions":
                $resultat = $resultat . " ";
                break;
        }

        fintraitementfrancs:
        $resultat = $resultat ; // 

        if ($nb > 2) {
            $resultat = $resultat;
        }

        // traitement des Ctss
        $varnum = (int)(($nb - (int)$nb) * 100 + 0.5);
        if ($varnum > 0) {
            $this->centaineDizaine($varlet, $varnum, $resultat); 
            $resultat = $resultat . $varlet;
            if ($varnum > 1) {
                $resultat = $resultat . " ";
            }
        }

        // conversion 1ère lettre en majuscule
        $resultat = ucfirst(substr($resultat, 0, 1)) . substr($resultat, 1);

        // renvoi du resultat de la fonction et fin de la fonction
        return $resultat;
    }

    // sous-programme
    private function centaineDizaine(&$varlet, &$varnum, &$resultat)
    {
        $varlet = " ";

        // traitement des millions
        if ($varnum >= 1000000) {
            $millions = $this->chiffre[(int)($varnum / 1000000)];
            $varnum = $varnum % 1000000;
            $varlet = ($milliere === "un") ? "millions " : $millions . " millions ";
        }

        // traitement des milliers
        if ($varnum >= 1000) {
            $milliers = $this->chiffre[(int)($varnum / 1000)];
            $varnum = $varnum % 1000;
            $varlet = ($milliers === "un") ? "mille " : $milliers . " mille ";
        }

        // traitement des centaines
        if ($varnum >= 100) {
            $centaine = $this->chiffre[(int)($varnum / 100)];
            $varnum = $varnum % 100;

            // Check gender for "centaine"
            $varlet = ($centaine === "un") ? "cent " : $centaine . " cent ";
        }

        // traitement des dizaines
        if ($varnum <= 19) {
            if ($varnum > 0) {
                $varlet = $varlet . $this->chiffre[$varnum];
            }
        } else {
            $varnumD = (int)($varnum / 10);
            $varnumU = $varnum % 10;

            switch ($varnumD) {
                case $varnumD <= 5:
                    $varlet = $varlet . $this->dizaine[$varnumD];
                    break;
                case 6:
                case 7:
                    $varlet = $varlet . $this->dizaine[6];
                    break;
                case 8:
                case 9:
                    $varlet = $varlet . $this->dizaine[8];
                    break;
            }

            if ($varnumU == 1 && $varnumD < 8) {
                $varlet = $varlet . " et ";
            } else {
                if ($varnumU != 0 || $varnumD == 7 || $varnumD == 9) {
                    $varlet = $varlet . " ";
                }
            }

            if ($varnumD == 7 || $varnumD == 9) {
                $varnumU = $varnumU + 10;
            }

            if ($varnumU != 0) {
                $varlet = $varlet . $this->chiffre[$varnumU];
            }
        }

        $varlet = rtrim($varlet);

        // Handle gender for "centaine"
        if (stripos($varlet, "cent ") !== false) {
            $varlet = str_replace("cent ", "cent ", $varlet);
        }
    }
}