# @data_provider data_greater_than
function test_greater_than() {
	bin/version gt $1 $2 2>&1
  	local exit_code=$?

	assert_equals 0 $exit_code;
}

# @data_provider data_not_greater_than
function test_not_greater_than() {
	bin/version gt $1 $2 2>&1
  	local exit_code=$?

	assert_equals 1 $exit_code;
}

function data_not_greater_than() {
	echo "1.0.0" "1.0.0"; # Equal.
	echo "v2.0.0" "v2.1.0"; # Less than.
	echo "3.5.2-alpha.1" "3.5.2-alpha.2"; # Less than with pre-release.
	echo "3.5.2-alpha.2+2" "3.5.2-alpha.2+1";
}

function data_greater_than() {
	echo "1.0.1" "1.0.0"; # Greater than.
	echo "v2.1.0" "v2.0.0"; # Greater than with prefix.
	echo "3.5.2-alpha.2" "3.5.2-alpha.1"; # Greater than with pre-release.
}
