#!/bin/sh

LAST_FM_USERNAME=ScottyWZ

cd "$(dirname -- "$0")"

if [ x"$LAST_FM_USERNAME" != x"" ]; then
 ~/bin/private/lastgraph -p '1 year' -s sunset -o graph.svg "$LAST_FM_USERNAME" >/dev/null
 cp -a graph.svg ../../../_site/other/lastgraph/
else
 echo "$(basename -- "$0"): error: LAST_FM_USERNAME is empty in this script" >&2
 exit 2
fi
