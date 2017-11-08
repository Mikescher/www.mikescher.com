SharkSim is my take on a Wa-Tor simulation ([wikipedia.org/wiki/Wator](wikipedia.org/wiki/Wator))

The rules of this [cellular automaton](http://en.wikipedia.org/wiki/Cellular_automaton) are:

> Time passes in discrete jumps, which I shall call chronons.
> During each chronon a fish or shark may move north, east, south or west to an adjacent point, provided the point is not already occupied by a member of its own species.
> A random-number generator makes the actual choice.
> For a fish the choice is simple: select one unoccupied adjacent point at random and move there.
> If all four adjacent points are occupied, the fish does not move.
> Since hunting for fish takes priority over mere movement, the rules for a shark are more complicated:
> from the adjacent points occupied by fish, select one at random, move there and devour the fish.
> If no fish are in the neighborhood, the shark moves just as a fish does, avoiding its fellow sharks.

My implementation is not that fancy - but it gets to a stable FPS rate of 45 with a map of the size 600x600.  
