CanvasCellSim
=============

Simulate a cellular automata and render it onto a canvas.

Contains a bunch of example configurations in `ccs_examples.ts` but can be freely configured with a custom transitioning function.

**See [the the github page](https://mikescher.github.io/CanvasCellSim/) for examples**

Included Examples:
- Game of Life
- Game of Life (with decay)
- Forest Fire
- Spiders and Mosquitoes
- Cyclic
- Pobalistic Cyclic
- Caves
- Mazes1
- Mazes2
- Seed
- Seed (with decay)
- Generic Lifelike (configure via [RuleString](https://www.conwaylife.com/wiki/Rulestring) or [RuleInteger](https://www.conwaylife.com/wiki/Rule_integer))

Support for
- resizing canvas
- wrapping or clamping edges
- Moore or Neumann neigbourhoods (or custom transitioning)
- performant drawing (cache colors and only render changes)