#!/bin/bash

if ! [ $(id -u) = 48 ]; then
   echo "su - dummyapache"
   exit 1
fi

cd var
../bin/console export:workslist 

