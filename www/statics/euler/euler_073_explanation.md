Here we brute-force through every possible denominator `d` (from 1 to 12000).
For every denominator the valid numerators are between `floor(d/3)` and `ceil(d/2)`.

The only problem is that we don't know if a fraction is proper.
To solve this we use a `12000x12000` array where we mark the already found fractions and every multiple of them.
When we now find a new one we can test if we have already found the fraction (in a reduced form).

But a `12000x12000` array is *quite* big, the resulting b93-file was 140MB big.
But we know that most of the array will never be accessed,
only the columns between `d/3` and `d/2` are important and the biggest range is in the last row (`LIMIT/3 - LIMIT/2`).
So in each array-acess we modulo the x coordinate by `LIMIT/3 - LIMIT/2` (= `2000`).
Now our array has only a size of `12000x2000` and the befunge-file is *only* 23MB big.

The program is not that fast, but that's mostly because of it's raw size, the algorithm is quite good (`200ms` when I implement it in C#)