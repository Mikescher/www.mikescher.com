Not much to say here, a bit of input parsing,
then looping through all lines and testing the triangles
with [this](http://blackpawn.com/texts/pointinpoly/default.html) basic algorithm.

Because the program is already pretty fast we don't spend much time optimizing it,
that means most variables have fixed grid values, even though I could optimize a few
to live only on the stack.
