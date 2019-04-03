<?php
function bin2dec($decNum){
	for($i=0;(pow(2,$i))<=$decNum;$i++){
		}
	$i=$i-1;
	$binNum=[];
	for($i;$i>=0;$i--){
		if(($decNum-pow(2,$i))>=0){
			$decNum = ($decNum-pow(2,$i));
			$binNum[]=pow(2,$i);
		}else{
			}
		}

		return $binNum;
}
?>
