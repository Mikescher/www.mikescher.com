I like the occasionally really easy problems between the others. It's like a little break sometimes.

The "trick" here is to understand the modulo operator. If you have `(a + b) % c` you can also write `a%c + b%c`.
And also you can write `(a * b)%c` as `(a%c) * (b%c)`.

So all we do is calculate the sum kinda normally, but we do modulo `10^10` after each step (every addition and multiplication).
We guarantee this way that out numbers never exceed the range of an 64bit integer.