all: db/episodes episodes.html episodes.md index.md

db/episodes: db/seasons db/names db/summaries
	./make-db

episodes.html: episodes.tpl.html db/episodes episodes.md
	./make-md $< > $@

episodes.md: index.tpl.md db/episodes
	./make-md > $@

index.md: index.tpl.md db/episodes
	./make-md $< > $@
