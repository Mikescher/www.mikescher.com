I was a bit lazy with this problem. The first thing i did was search on OEIS for the numerator and denominator sequences.
And I found both, they are **A123335** and **A000129**.
But still there are two mayor problems:
 - First these are recursive functions, so we need to store the last and the second last result. This is again the reason why our programs exceeds the Befunge-93 size restrictions. We need three fields for the numerator and three for the denominator (Current value | Last value | Second last value).
 - Second the numbers become big. Like *really* big. The last values get close to four hundred digits. So - again - we need to do the calculations manually *(long multiplication and addition)*

In the end we have a reasonable fast program with six 79*5 arrays for value storage.