This problem is the reason why I changed the internals of my interpreter to int64 (because the numbers are too big for int32).

Fortunately the number is still small enough to brute-force the prime factors, going from the biggest factor to the smallest, the first factor (that is also a prime) that my code finds is the solution.