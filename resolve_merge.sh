#!/bin/bash

function parseMine {
	echo "SOLVING CONFLICT IN $1 WITH MINE"
	cat $1 | sed '/=======/,/>>>>>>>/d' | sed '/<<<<<<</d' > $1.mine
	mv $1.mine $1
}

function parseTheirs {
	echo "SOLVING CONFLICT IN $1 WITH THEIRS"
	cat $1 | sed '/<<<<<<</,/=======/d' | sed '/>>>>>>>/d' > $1.theirs
	mv $1.theirs $1
}

TEXTFILES=`grep --include=\*.{css,html,xml,js,php} -rnwl '.' -e "\<HEAD"`

for TEXTFILE in $TEXTFILES
do
	if [ "$1" == "mine" ]; then
		parseMine $TEXTFILE;
	elif [ "$1" == "theirs" ]; then
		parseTheirs $TEXTFILE;
	fi
done
