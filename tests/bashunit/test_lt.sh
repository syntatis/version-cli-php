# @data_provider data_less_than
function test_less_than() {
	bin/version lt $1 $2 2>&1
  	local exit_code=$?

	assert_equals 0 $exit_code;
}

# @data_provider data_not_less_than
function test_not_less_than() {
	bin/version lt $1 $2 2>&1
  	local exit_code=$?

	assert_equals 1 $exit_code;
}

function data_less_than() {
	echo "1.0.0" "1.0.1";
	echo "v2.0.0" "v2.1.0";
	echo "3.5.2-alpha.1" "3.5.2-alpha.2";
}

function data_not_less_than() {
	echo "1.0.0" "1.0.0"; # Equal.
	echo "v2.0.0" "v1.0.0"; # Greater than.
	echo "3.5.1-alpha.2" "3.5.1-alpha.1"; # Greater than with pre-release.
}
