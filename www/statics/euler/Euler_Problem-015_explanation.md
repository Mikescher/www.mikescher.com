We create a 21x21 grid of the edges in our graph, then we set the value on each edge to the number of possible paths to (0|0).  
For the top-left edge this is `1`. For the edges in the first row/column it is also `1`. For every other edge it is the above edge + the left edge.  
And in the end we are only interested in the value of the bottom-right edge - this value is our result.