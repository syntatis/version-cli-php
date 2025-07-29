# @data_provider data_increment_patch
function test_increment_patch() {
	ver=$(bin/version increment $1);
	assert_equals $ver $2;
}

# @data_provider data_increment_minor
function test_increment_minor() {
	ver=$(bin/version increment $1 --part minor);
	assert_equals $ver $2;
}

# @data_provider data_increment_major
function test_increment_major() {
	ver=$(bin/version increment $1 --part major);
	assert_equals $ver $2;
}

# @data_provider data_increment_with_pre_release
function test_increment_with_pre_release() {
	ver=$(bin/version increment $1 --pre alpha);
	assert_equals $ver $2;
}

# @data_provider data_increment_with_build
function test_increment_with_build() {
	ver=$(bin/version increment $1 --build 123);
	assert_equals $ver $2;
}

# @data_provider data_increment_with_pre_release_and_build
function test_increment_with_pre_release_and_build() {
	ver=$(bin/version increment $1 --build 123 --pre alpha);
	assert_equals $ver $2;
}

function data_increment_patch() {
	echo "0.0.0" "0.0.1";
	echo "1.0.0" "1.0.1";
}

function data_increment_minor() {
	echo "0.0.0" "0.1.0";
	echo "1.0.0" "1.1.0";
}

function data_increment_major() {
	echo "0.0.0" "1.0.0";
	echo "1.0.0" "2.0.0";
}

function data_increment_with_pre_release() {
	echo "0.0.0" "0.0.1-alpha";
	echo "1.0.0" "1.0.1-alpha";
}

function data_increment_with_pre_release_and_build() {
	echo "0.0.0" "0.0.1-alpha+123";
	echo "1.0.0" "1.0.1-alpha+123";
}
