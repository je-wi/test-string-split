# test-string-split
Testing speed of splitting NFD-strings

## Testfiles in tlg_tok_tsv
````        
        tlg_tok_tsv/
          0001/
            0001-001.tsv
            0001-002.tsv
            0001-003.tsv
          0002/
            0002-001.tsv
            0002-002.tsv 
            0002-003.tsv
            0002-004.tsv 
  ````   
  
## test_mb_string_split.php

### 0. without splitting the strings: use of file() and explode() for loading the content

### 1. mb_split_array: own helper function, use of mb_strlen() and mb_substr() for splitting
    
        #$linearray = mb_split_array($line[1]);   

### 2. preg_split: use regular expression with negative lookbehind for splitting  

        #$linearray = preg_split( '/(?<!^)(?!$)/u', $line[1] );
        
### 3. mb_str_split: future release PHP >= 7.4 

        #$linearray = mb_str_split($line[1]); # !!! PHP 7.4     
        

## Tests
The tests where performed localy on different computers to illustrate the tendency and not the computer performance.

Testfiles in seconds | 0 | 1 | 2 | 3 |
:--- | ---: | ---: | ---: | ---: |
Windows 8.1, Apache 2.4.27 (Win 64), PHP 7.1.9 | 3.4 | 12.2 | 5.8 | not yet tested |
Mint 19.1, Apache 2.4.29 (Ubuntu), PHP 7.24 | 13.6 | 23.2 | 15.8 | not yet tested |
Debain 10, Apache 2.4.38 (Debian), PHP 7.3.14-1 | 8.9 | 18.4 | 13 | not yet tested |

Complete TLG-E in seconds | 0 | 1 | 2 | 3 |
:--- | ---: | ---: | ---: | ---: |
Windows 8.1, Apache 2.4.27 (Win 64), PHP 7.1.9 | 152 | 556 | 261 | not yet tested |
Mint 19.1, Apache 2.4.29 (Ubuntu), PHP 7.24 | 628 | 1081 | 775 | not yet tested |
Debain 10, Apache 2.4.38 (Debain), PHP 7.3.14-1 | 481 | 967 | 699 | not yet tested |

