#!/bin/sh

CPROOT=/var/captiveportal/zone0

echo $CPROOT

#php-cgi
mkdir -p $CPROOT/usr/local
cp /usr/local/bin/php-cgi $CPROOT/usr/local
echo fin mkdir
LIBS=`ldd /usr/local/bin/php-cgi | awk '{print $3}'`
for i in $LIBS
do
	  DIR=`dirname $i`
	  if [ ! -d $CPROOT/$DIR ]; then
	      mkdir -p $CPROOT$DIR
	  fi
	  cp $i $CPROOT$DIR/
done

#php extensions
mkdir -p $CPROOT/usr/local/lib/php
cp -r /usr/local/lib/php/2* $CPROOT/usr/local/lib/php/

#extensions libs
for R in `cat required`
do
    echo $R
    LIBS=`ldd $R | awk '{print $3}'`
    for i in $LIBS
    do
      DIR=`dirname $i`
      if [ ! -d $CPROOT/$DIR ]; then
          mkdir -p $CPROOT$DIR
      fi
      cp $i $CPROOT$DIR/
   done
done
