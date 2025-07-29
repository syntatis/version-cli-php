# @data_provider data_sucess
function test_success() {
	bin/version eq $1 $2 2>&1
  	local exit_code=$?

	assert_equals 0 $exit_code;
}

# @data_provider data_failure
function test_failure() {
	bin/version eq $1 $2 2>&1
  	local exit_code=$?

	assert_equals 1 $exit_code;
}

function data_failure() {
	echo "1.0.0 1.0.1";
	echo "v2.0.0 v2.1.0";
	echo "3.5.2-alpha.1 3.5.2-alpha.2";
}

function data_sucess() {
	echo "1.0.0 1.0.0";
	echo "v2.0.0 v2.0.0";
	echo "3.5.1-alpha.1 3.5.1-alpha.1";
	echo "4.0.0-beta.2+1 4.0.0-beta.2+2"; // Build metadata should not affect equality.
	echo "4.2.0-beta.2+1 4.2.0-beta.2+1";
}
