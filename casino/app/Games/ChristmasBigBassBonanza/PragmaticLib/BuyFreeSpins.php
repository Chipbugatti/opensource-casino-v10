<?php

namespace VanguardLTE\Games\ChristmasBigBassBonanza\PragmaticLib;

class BuyFreeSpins
{
    public static function getFreeSpin(&$slotArea, $gameSettings, $cnt, $max){
        $reels = [
            [0, 5, 10],  [1, 6, 11], [2, 7, 12], [3, 8, 13], [4, 9, 14]
        ];
        $reelPosition = [-1, -1, -1, -1, -1];
        if($cnt == 0)
            $cnt = self::getCnt();
        $cnt = $cnt > $max ? $max : $cnt;
        $scatterTmp = explode('~',$gameSettings['scatters']);
        $scatter = $scatterTmp[0];
        $scatterPositions = array_keys($slotArea, $scatter);

        foreach($scatterPositions as $value){
            $reelPosition[$value % 5] = round($value / 5, 0);
        }
        while(count($scatterPositions) < $cnt){
            $index = rand(0, 4);
            if($reelPosition[$index] == -1){
                $reelPosition[$index] = rand(0, 2);
                $scatterPositions[] = $index + $reelPosition[$index] * 5;
                $slotArea[$scatterPositions[count($scatterPositions) - 1]] = $scatter;
            }
        }
        var_dump('1_0_cnt='.$cnt.'_sPos='.implode(',', $scatterPositions).'_s='.implode(',', $slotArea));
        return $cnt;
    }

    public static function getWild(&$slotArea, $gameSettings, $cnt, $max, $log){
        $reels = [
            [0, 5, 10],  [1, 6, 11], [2, 7, 12], [3, 8, 13], [4, 9, 14]
        ];
        $reelPosition = [-1, -1, -1, -1, -1];
        if($cnt == 0)
            $cnt = self::getWildCnt($log);
        var_dump('cnt='.$cnt);
        $cnt = $cnt > $max ? $max : $cnt;
        $wild = 2;
        $wildPositions = array_keys($slotArea, $wild);

        foreach($wildPositions as $value){
            $reelPosition[$value % 5] = round($value / 5, 0);
        }
        while(count($wildPositions) < $cnt){
            $index = rand(0, 4);
            if($reelPosition[$index] == -1){
                $reelPosition[$index] = rand(0, 2);
                $wildPositions[] = $index + $reelPosition[$index] * 5;
                $slotArea[$wildPositions[count($wildPositions) - 1]] = $wild;
            }
        }
        var_dump('1_0_cnt='.$cnt.'_sPos='.implode(',', $wildPositions).'_s='.implode(',', $slotArea));
        return $cnt;
    }

    private static function getCnt(){
        $rn = rand(1, 1000);
       // if($rn >= 0 && $rn <= 0) return 5;
      //  if($rn >= 11 && $rn <= 11)    return 4;
        if($rn >= 16 && $rn <= 17)    return 3;
        if($rn >= 51 && $rn <= 101)    return 2;
        if($rn >= 151 && $rn <= 201)    return 1;
        return 0;
    }

    private static function getWildCnt($log){
        $rn = rand(1, 1000);
        if($log && array_key_exists('accv', $log)){
            $accv = $log['accv'];
            $accv = explode('~', explode(';', $accv)[1])[0];
        }
        else $accv = 1;
        var_dump('rn='.$rn);
        if($rn <= 490 - $accv * 100)
            return 1;
        return 0;
    }
}
