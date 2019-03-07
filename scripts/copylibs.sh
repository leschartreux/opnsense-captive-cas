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

#extensions
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
