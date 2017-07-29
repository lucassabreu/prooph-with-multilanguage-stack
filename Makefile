all: protobuf

protobuf-generate:
	rm -rf ./proto/build/php-src
	mkdir -p ./proto/build/php-src
	protoc --proto_path=proto --php_out=proto/build/php-src proto/events.proto
	protoc --proto_path=proto --php_out=proto/build/php-src proto/commands.proto

protobuf-without-prooph: protobuf-generate
	rm -rf ./without-prooph/proto
	cp -r ./proto/build/php-src ./without-prooph/proto

protobuf-with-prooph: protobuf-generate
	rm -rf ./with-prooph/proto
	cp -r ./proto/build/php-src ./with-prooph/proto

protobuf: protobuf-generate protobuf-with-prooph protobuf-without-prooph

