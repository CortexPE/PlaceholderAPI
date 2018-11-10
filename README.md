# PlaceholderAPI [![Poggit](https://poggit.pmmp.io/ci.shield/CortexPE/PlaceholderAPI/~)](https://poggit.pmmp.io/ci/CortexPE/PlaceholderAPI/~)
Simple barebones API to implement centralized static and dynamic placeholders/variables with ease

Originally made for my own server, Just publicized because I think the "community" needs something to make global string variables less of a pain in the a$$... Useful for HUD plugins, Displaying data provided by other plugins, and many other ways...

## Pros & Cons
**Pros:**
 - Flexible Dynamic Variables / Placeholders
 - Simply does one thing. Implement & Manage global placeholders or variables in PocketMine-MP
 - For developers, you don't need to worry about other plugins regarding globally available strings or variables
 - This does not need the registrant plugin's instance to work by itself... Assuming you didn't tell it to call the registrant's plugin xD

**Cons:**
 - There's none (right now) that I could think of that would be considered as a negative aspect of this API

***Keep in mind however, This is not intended to be like [Spigot's PlaceholderAPI](https://www.spigotmc.org/resources/placeholderapi.6245/). Your plugins have to implement the placeholders themselves. The API is simple enough to follow.***

## FYI
 **Q:** But Cortex, can't these placeholders be f'ed up by other plugins overwriting them?
 <br />
 **A:** Yes. But this plugin tells you whenever that happens and what "plugin" / registrant (can be bypassed if the developer is a d!¢k) did it. If you consider that an attack vector, there's still thousands of ways to do so even without using this plugin.
 
 
 **Q**: How do I do *X*???
 <br />
 **A**: Use logic :)
 
 **Q**: This is so useless, I could easily implement this in many other ways...
 <br />
 **A**: Then don't use it. There's ways on how to do this by directly getting the plugin's instance and directly calling it but that needs a ton of boilerplate code that can easily be solved by making a simple global variable management system (like this)

## Usage
You may look at [test/PlaceholderTest.php#L47-L98](https://github.com/CortexPE/PlaceholderAPI/blob/master/test/PlaceholderTest.php#L47-L98) for basic usage of Static and Dynamic placeholders the API can offer.
