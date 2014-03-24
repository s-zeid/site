#!/bin/bash

cd "$(dirname "$0")"
/home/scottywz/bin/private/lastgraph -p '1 year' -s sunset -o graph.svg ScottyWZ >/dev/null
cp -a graph.svg ../../../_site/other/lastgraph/
