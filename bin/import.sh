#!/bin/bash

if ! [ $(id -u) = 48 ]; then
   echo "su - dummyapache"
   exit 1
fi

bin/console import:workslist OVERWRITE /.reserved/r/public/webprojects/ttui/data/commesse-2020.csv
