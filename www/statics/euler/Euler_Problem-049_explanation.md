This could be the first problem with prime numbers but without a prime sieve.  
We iterate through the numbers from `1488` to `3340` and search for palindromes. 
To speed up the palindrome calculation we calculate the product of each digit plus two and compare the product of our three numbers.
This is only an approximation, but a rather good one. In tested the numbers from `0` to `100 000` and there were **zero** failures.

So now we've got the numbers where `digit_product(p) == digit_product(p+3330) == digit_product(p+6660)` (in fact there are only 40 of these).
We then use a simple primality test to check if all three numbers are prime.  
The primality test is basically a port of the [wikipedia](https://en.wikipedia.org/wiki/Primality_test) version to befunge. Wit it we only have to do `n/6` divisions to test a number `n` for primality.

All in all tis leads to a fast, small and not very grid-intensive program (Only one field is used, *and only as a temporary storage to swap three values*).