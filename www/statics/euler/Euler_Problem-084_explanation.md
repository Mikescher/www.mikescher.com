This is not really a mathematical problem (or at least not with my solution).

All I did was implement the rules in my befunge program and run a randomized game for `1 000 000` turns.
This is called an [Monte Carlo algorithm](https://en.wikipedia.org/wiki/Monte_Carlo_algorithm) and if we have enough runs it becomes pretty improbable to get a wrong result.

Perhaps there are some fancy mathematical solutions out there, but this works too.

A note to the befunge code: It got pretty messy because of all the decisions we have to implement for the different monopoly rules,
but all we needed as storage was an 40-element array. So it wasn't that hard to fit it all in the 80x25 space.