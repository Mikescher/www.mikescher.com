The *trick* here is that we only need to test 1998 numbers. Because there are only so much base10 palindromes:

- The numbers from `1` to `999` mirrored result into to palindromes `11` to `999999`
- The numbers from `1` to `999` mirrored at the last digit result into to palindromes `1` to `99999`

Then we only need to test these numbers whether they are also binary palindromes. 