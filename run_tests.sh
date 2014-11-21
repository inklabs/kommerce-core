#!/usr/bin/env bash
echo '<pre>';
cd $TM_PROJECT_DIRECTORY;

# Run unit tests
/usr/bin/php -c ~/.php.ini vendor/bin/phpunit | ~/bin/aha --no-header --black

SUCCESS=${PIPESTATUS[0]}

# Check PHP Codesniffer
if [ $SUCCESS -eq 0 ] && [ -f vendor/bin/phpcs ]; then
    echo '<hr/>';
    # /usr/bin/php -c ~/.php.ini vendor/bin/phpcs --standard=PSR2 $TM_FILEPATH
    /usr/bin/php -c ~/.php.ini vendor/bin/phpcs --standard=PSR2 src tests
    SUCCESS=$?
fi

# Run coverage report
if [ $SUCCESS -eq 0 ]; then
    echo '<hr/>';
    /usr/bin/php -c ~/.php.ini vendor/bin/phpunit --coverage-text --coverage-html coverage_report | ~/bin/aha --no-header --black
    echo '<a href="file://'$TM_PROJECT_DIRECTORY'/coverage_report/index.html">Report</a>';
fi

echo '</pre>'
