#!/bin/bash
var=`find . -type f | egrep "(^./app|^./bin|^./src|^./web)" | egrep "(.js$|.php$|.twig$|.css$)"`
count=0
for v in $var; do
    count=$((`wc -w $v | egrep -o "^[^ ]+"`+$count))
done
echo "Total = $count"
