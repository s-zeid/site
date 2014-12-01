all: db/episodes episodes.md index.md

db/episodes: db/seasons db/names db/summaries
	./make-db

episodes.md: db/episodes template.md
	./make-md > episodes.md

index.md: db/episodes template.md
	./make-md template.md > index.md
