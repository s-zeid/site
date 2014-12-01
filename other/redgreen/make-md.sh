#!/bin/sh

season_db_file=` dirname "$0"`/db/seasons
episode_db_file=`dirname "$0"`/db/episodes

make_db=`        dirname "$0"`/make-db

IFS='
'

main() {
 [ ! -e "$episode_db_file" ] && "$make_db"
 make_markdown "$@"
}

season_numbers() {
 local line season
 for line in `cat "$season_db_file"`; do
  season=`      printf '%s' "$line" | cut -d'|' -f1`
  printf '%s\n' "$season"
 done
}

season_range() {
 local season line range
 season=$1
 range=`grep "^$season|" "$season_db_file" | head -n1 | cut -d'|' -f2 | sed 's/,/\n/g'`
 printf '%s\n' "$range"
}

markdown_header() {
 local level=$1 text=$2 id=$3 extra=$4
 if [ $level -eq 1 ] || [ $level -eq 2 ]; then
  # setext-style header
  printf '%s' "$text"
  [ x"$extra" != x"" ] && printf ' %s'    "$extra"
  [ x"$id"    != x"" ] && printf ' {#%s}' "$id"
  printf '\n'
  if [ $level -eq 1 ]; then
   for i in $(seq 1 `printf '%s' "$text" | wc -c`); do printf '='; done
  else
   for i in $(seq 1 `printf '%s' "$text" | wc -c`); do printf '-'; done
  fi
 else
  # atx-style-header
  for i in $(seq 1 $level); do printf '#'; done; printf ' '
  printf '%s' "$text"
  [ x"$extra" != x"" ] && printf ' %s'    "$extra"
  [ x"$id"    != x"" ] && printf ' {#%s}' "$id"
 fi
}

markdown_episodes() {
 local season season_human range episode episode_human url name summary
 for season in $(season_numbers); do
  season_human=`printf '%s' "$season" | sed -e 's/^0*//g'`
  range=$(printf '%s–%s' `season_range "$season" | sed -e 's/^0*//g'`)
  [ $season -ne 1 ] && printf '\n\n* * * *\n\n'
  markdown_header 2 "Season $season_human" "season-$season_human" \
                    "(Episodes $range) [#](#season-$season_human)"
  
  for episode in $(seq `season_range $season`); do
   printf '\n\n'
   episode=`printf '%03d' "$episode"`
   episode_human=`printf '%s' "$episode" | sed -e 's/^0*//g'`
   url=`    grep "^$episode|" "$episode_db_file" | head -n1 | cut -d'|' -f4`
   name=`   grep "^$episode|" "$episode_db_file" | head -n1 | cut -d'|' -f3`
   summary=`grep "^$episode|" "$episode_db_file" | head -n1 | cut -d'|' -f5`
   
   markdown_header 3 "Episode $episode_human — $name" "episode-$episode_human" \
                     "[#](#episode-$episode_human)"
   printf '\n\n'
   printf "$summary"
   if [ x"$url" != x"" ]; then
    printf '\n[Watch on YouTube](%s){: target="_blank"}' "$url"
   fi
  done
 done
}

markdown_contents() {
 local longest_length season season_human range text length
 longest_length=0
 for season in $(season_numbers); do
  season_human=`printf '%s' "$season" | sed -e 's/^0*//g'`
  range=$(printf '%s–%s' `season_range "$season" | sed -e 's/^0*//g'`)
  text="Season $season_human (Episodes $range)"
  length=`printf '%s' "$text" | wc -c`
  if [ $length > $longest_length ]; then
   longest_length=$length
  fi
 done
 for season in $(season_numbers); do
  season_human=`printf '%s' "$season" | sed -e 's/^0*//g'`
  range=$(printf '%s–%s' `season_range "$season" | sed -e 's/^0*//g'`)
  text="Season $season_human (Episodes $range)"
  length=`printf '%s' "$text" | wc -c`
  padding=""
  for i in `seq 1 $((longest_length - length))`; do
   padding="$padding "
  done
  printf ' %s:%s %s\n' "$text" "$padding" "season-$season_human"
 done
}

make_markdown() {
 local template=$1
 if [ x"$template" != x"" ]; then
  contents=`markdown_contents`
  episodes=`markdown_episodes`
  OIFS=$IFS; IFS=''
  cat "$template" | awk -v contents="$contents" -v episodes="$episodes" '
   /\{\$ *contents *\$\}/ {
    $0=contents
   }
   /\{\$ *episodes *\$\}/ {
    $0=episodes
   }
   { print $0 }
  '
  IFS=$OIFS
 else
  markdown_episodes
  printf '\n'
 fi
}

main "$@"
