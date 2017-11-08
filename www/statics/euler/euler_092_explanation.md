My approach to this problem is pretty crude. Perhaps I will later come back and try to find a better algorithm.
Currently we iterate (brute-force) through all possible numbers and count the chains that end with one.
The `next()` function is implemented like this:

~~~~~~~~~~~~~~~~~~~
0\>:55+%:*\ :#v_$$
  ^/+55g05+p05<   
~~~~~~~~~~~~~~~~~~~

We also remember in an 8x71 cache all previously found numbers so we can abort some sequences before we reach `1` or `89`.
This is the main optimization from pure brute-force in this program.

We can prove that an 568-element cache is enough because no number in the sequence (except the first) can be greater than `9^2 * 7` (` = 567`)