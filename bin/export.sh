#!/bin/bash

if ! [ $(id -u) = 48 ]; then
   echo "su - dummyapache"
   exit 1
fi

bin/console export:workslist 

