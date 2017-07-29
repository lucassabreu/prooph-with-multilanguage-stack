all: protobuf

protobuf:
	rm -rf ./proto/build/php-src
	mkdir -p ./proto/build/php-src
	protoc --proto_path=proto --php_out=proto/build/php-src proto/events.proto
	protoc --proto_path=proto --php_out=proto/build/php-src proto/commands.proto
	rm -rf ./without-prooph/proto ./with-prooph/proto
	cp -r ./proto/build/php-src ./without-prooph/proto
	cp -r ./proto/build/php-src ./with-prooph/proto

