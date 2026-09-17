# Smell baseline (Fowler, Refactoring ch.3)

Paste this full file into the Standards sub-agent prompt. Repo-documented standards override these smells. Each smell is a **judgement call**, never a hard violation. Skip anything Pint already catches.

Each item: *what it is* → *how to fix*. Match against the diff.

- **Mysterious Name**: a function, variable, or type whose name does not reveal what it does or holds. → rename it; if no honest name comes, the design is murky.
- **Duplicated Code**: the same logic shape appears in more than one hunk or file in the change. → extract the shared shape (Suave: local scopes, `{Feature}Service`, Form Request Concerns, `*Section` components).
- **Feature Envy**: a method that reaches into another object's data more than its own. → move the method onto the data it envies (instance methods on the model, not the service).
- **Data Clumps**: the same few fields or params keep travelling together. → bundle them into one type or array shape.
- **Primitive Obsession**: a primitive or string standing in for a domain concept. → give the concept its own small type or const set.
- **Repeated Switches**: the same `switch` / `if`-cascade on the same type recurs. → replace with polymorphism, or one map both sites share.
- **Shotgun Surgery**: one logical change forces scattered edits across many files. → gather what changes together (Support class, Service, Section component).
- **Divergent Change**: one file is edited for several unrelated reasons. → split so each unit changes for one reason (new `{Feature}Service`).
- **Speculative Generality**: abstraction added for needs the spec does not have. → delete it; inline until a real need shows.
- **Message Chains**: long `a.b().c().d()` navigation. → hide the walk behind one method on the first object.
- **Middle Man**: a class that mostly just delegates onward. → cut it (do not invent middle layers around thin controllers).
- **Refused Bequest**: a subclass that ignores most of what it inherits. → drop the inheritance, use composition.
