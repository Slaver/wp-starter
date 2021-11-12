#!/bin/bash
# find all using classes in php files
grep -r --include "*.php" -Eoh 'class="[^\"]+"' | while read -r line ; do
    LINE1=`echo $line | sed 's/class=\"//' | sed -e 's/<[^>]*>//g' | sed 's/"//' | sed 's/%2$s//' | sed "s/'//"`
    echo "${LINE1}" | cut -d' ' -f1 | xargs
done < <(sort | uniq -u)