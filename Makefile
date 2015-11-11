include _template/build-site.mk

HOST := s.zeid.me
DIR  := ~/srv/www/s.zeid.me

deploy:
	ssh $(HOST) 'cd $(DIR); pwd; git pull && git submodule update && make'
