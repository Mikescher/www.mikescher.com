absCanvas is my very own java game engine. And by the time it is probably the project i used in the most other things.

The idea was to create a (in the beginning) very simple game engine that doesn't depend on other libraries.  
*(except a few, like a sound library - if you use sounds)*  
The drawing is down per Active-Rendering directly on the normal canvas.

The main advantage are the multiple integrated features like

- a complex menusystem with different components, different screens and even animated transitions between them.
- classes to support loading sprites from spritesheets and to create animated entities.
- configurable collision detection
- a *(not fully finished)* Network support where multiple people control different entities on the same world.
- my own custom map saveformat with IO classes and an editor

absCanvas was initially only for my own projects, and if you want to write a game you are probably better to just use one of the bigger game frameworks.  
But if you want to see a game framework, made completely from the bottom of java this could be interesting