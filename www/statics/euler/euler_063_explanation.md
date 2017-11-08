After all the previous programs, this one is surprisingly ... dense (the main code-block is 54x8).

The algorithm is quickly explained for each length n we calculate the numbers `1^n`, `2^n` ... until `9^n` and see which have a length of `n`.
(From `10^n` upwards the condition is impossible, because `10^n` has `(n+1)` digits).

The main problem is that the numbers exceed Int64. So we need to implement long multiplication ... again. (see problem 16, 20, 29, 56 and 57)