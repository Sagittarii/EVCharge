#!/usr/bin/bash
isfirst=1


echo "{"

for f in *.csv
do
	if [ $isfirst -eq 0 ]
	then
		echo ,
	fi
	echo \"$f\" : {
	echo \"capacity\": 28,

	echo \"power\" : [ 
	tail -n +16 $f | cut -f 3 -d';' | tr '\n' ',' | sed -e "s/,$//"
	echo ],

	echo \"voltage\" : [ 
	tail -n +16 $f | cut -f 4 -d';' | tr '\n' ',' | sed -e "s/,$//"
	echo ],
	
	echo \"current\" : [ 
	tail -n +16 $f | cut -f 5 -d';' | tr '\n' ',' | sed -e "s/,$//"
	echo ]
	
	
	echo }
	isfirst=0
done

echo }
# tail -n +16 Fiche_charge_zeta_NISSAN_LEAF_40.csv | head | cut -f 3 -d';' | tr '\n' ';'
