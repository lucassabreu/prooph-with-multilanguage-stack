all: protobuf

protobuf-generate:
	rm -rf ./proto/build/php-src
	mkdir -p ./proto/build/php-src
	protoc --proto_path=proto --php_out=proto/build/php-src proto/events.proto
	protoc --proto_path=proto --php_out=proto/build/php-src proto/commands.proto

protobuf-prooph-producer: protobuf-generate
	rm -rf ./prooph-producer/proto
	cp -r ./proto/build/php-src ./prooph-producer/proto

protobuf-prooph-consumer: protobuf-generate
	rm -rf ./prooph-consumer/proto
	cp -r ./proto/build/php-src ./prooph-consumer/proto

protobuf: protobuf-generate protobuf-prooph-consumer protobuf-prooph-producer

