all: db/episodes episodes.md index.md

db/episodes: db/seasons db/names db/summaries
	./make-db

episodes.md: index.tpl.md db/episodes
	./make-md > $@

index.md: index.tpl.md db/episodes
	./make-md $< > $@
