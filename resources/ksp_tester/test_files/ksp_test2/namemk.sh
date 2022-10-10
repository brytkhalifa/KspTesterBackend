#!/bin/bash
chmod 755 njvm; 
for i in *;do 
	if [ "$i" != "njvm" ]; then
		if [ "$i" != "namemk.sh" ]; then 
			echo "name: $i"
			 ./njvm $i;
			  read f
			  mv $i v2$f.bin
		fi
	 fi 
done

