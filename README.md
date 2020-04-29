# test-string-split
Testing speed of splitting NFD-strings

### some testfiles here
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
### 0. without splitting: uncomment nothing  

### 1. mb_split_array: helper functions, mb_strlen() and mb_substr()
    
        #$linearray = mb_split_array($line[1]);   

### 2. preg_split: regular expression with negative lookbehind  

        #$linearray = preg_split( '/(?<!^)(?!$)/u', $line[1] );
        
### 3. mb_str_split: PHP >= 7.4 

        #$linearray = mb_str_split($line[1]); # !!! PHP 7.4     
        
