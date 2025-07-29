# @data_provider data_valid
function test_equal() {
	bin/version validate $1 2>&1
  	local exit_code=$?

	assert_equals 0 $exit_code;
}

# @data_provider data_invalid
function test_invalid() {
	bin/version validate $1 2>&1
  	local exit_code=$?

	assert_equals 1 $exit_code;
}

function data_valid() {
	echo "1.0.0"
	echo "v1.0.0"
	echo "2.1.7-alpha"
	echo "1.0.0-beta.1"
	echo "3.4.5+build.78"
	echo "0.9.1-alpha.1+exp.sha.5114f85"
}

function data_invalid() {
	echo "0"
	echo "0.0"
	echo "v"
	echo "v0"
	echo "v0.0"
}
