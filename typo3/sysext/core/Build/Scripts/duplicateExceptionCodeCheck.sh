#!/bin/bash

#########################
#
# Find duplicate exception timestamps and list them.
# Additionally find exceptions that have no exception code.
#
# It expects to be run from the core root.
#
##########################

cd typo3/

ignoreFiles=()
# auto generated file, shouldn't be checked
ignoreFiles+="sysext/core/Build/Configuration/Acceptance/Support/_generated/AcceptanceTesterActions.php"
# an exception in here throws up an code from a previous exception
ignoreFiles+="sysext/extbase/Classes/Core/Bootstrap.php"

# grep
# '-r' recursive
# '--include \*.php' in all .php files
# '-Pzoa' pcre regex, -zo remove all linebreaks for multiline match, treat all files as text, output position "filename:position: match"
# 'new ' strings starting with new and whitespace
# '([[:alnum:],\\\]|)*?' a-z,A-Z,0-9,\ as often as needed, non-greedy
# 'Exception\(' word Exception with opening parenthesis
# '(?s:.)*?,' any character including linebreaks as often as needed, non-greedy, followed by a comma (matches first argument)
# '([[:space:]])*?' maybe a space after first argument, non-greedy
# '(?s:.)*?\){1,10};$' any further number of characters including line breaks, non-greedy, then at least one closing parethisis and a semicolon

foundNewFile=0
oldFilename=""
firstLineOfMatch=""
foundExceptionInFile=1
exceptionCodes=()

grep \
    -r \
    --include \*.php \
    -Pzoab \
    "new ([[:alnum:],\\\]|)*?Exception\((?s:.)*?,([[:space:]])*?(?s:.)*?\);" \
    | \
while read line;
do
    possibleFilename=`echo ${line} | cut -d':' -f1`
    if [[ ${possibleFilename} =~ .php$ ]]; then
        # the matched line consists of a file name match, we're dealing with a new match here.
        foundNewFile=1
        oldFilename=${currentFilename}
        currentFilename=${possibleFilename}
    else
        foundNewFile=0
    fi

    # skip file if in blacklist
    if [[ {$ignoreFiles[@]} =~ ${currentFilename} ]]; then
        continue
    fi

    # check for match in previous file name
    if [[ ${foundNewFile} -eq 1 ]] && [[ ${foundExceptionInFile} -eq 0 ]]; then
        echo "File: $oldFilename"
        echo "The created exception contains no 10 digit exception code as second argument, in or below this line:"
        echo "$firstLineOfMatch"
        exit 1
    fi

    # reset found flag if we're handling new file
    if [[ ${foundNewFile} -eq 1 ]]; then
        foundExceptionInFile=0
        firstLineOfMatch=${line}
    fi

    # see if the line consists of an exception code
    if [[ "$line" =~ .*([0-9]{10}).* ]]; then
        foundExceptionInFile=1
        exceptionCode=${BASH_REMATCH[1]}
        # check if that code was registered already
        if [[ {$exceptionCodes[@]} =~ ${exceptionCode} ]]; then
            echo "Duplicate exception code ${exceptionCode} in file:"
            echo ${currentFilename}
            exit 1
        fi
        exceptionCodes+=${exceptionCode}
    fi
done || exit 1

exit 0