**Yes**. This is in fact the first program without *put* or *get* instructions. It operates completely on the stack. And that makes it **really** fast.

But *- to be fair -* the algorithm is pretty simple:

First get the upper bound for our later search, we search for a number where `digitcount(9^5 * n) <= n`

After our algorithm calculated that number (I resisted the urge to hard code `354294`) we test every number from 0 to limit and sum the fitting ones (there are only 6).  
`4150`, `4151`, `54748`, `92727`, `93084`, `194979`