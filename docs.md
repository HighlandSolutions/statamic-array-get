# Statamic Array Get Docs
## Overview
The `{{ array_get }}` tag simplifies outputting data nested in arrays. It shines when one or more of those keys are stored in a variable.


## Examples
While the examples all use front-matter variables, this tag works with any array-type variables. Using front-matter is simply the easiest way to illustrate the concept.

### Simple
```handlebars
---
low:
  one: Speed of Life
  two: Breaking Glass
---

{{ array_get:view:low.one }}  <!-- Speed of Life -->
{{ array_get:view:low.two }} <!-- Breaking Glass -->
{{ array_get:view:low.three }} <!-- (null) -->
{{ array_get:view:low.three default='What in the World' }} <!-- What in the World -->

<!-- Assume the variable {{ track_number }} is set to `one` -->
{{ array_get:view:low :key="track_number" }}  <!-- Speed of Life -->
```

### Real-world
For context, assume these two fields exist:

1. a Video field called `video`
2. a Radio field called `size` with the options `full_width`, `large`, `medium`, and `small`

<details>
  <summary>
    <i>Sample blueprint excerpt</i>
  </summary>

  ```yaml
  sections:
    main:
      display: Main
      fields:
        -
          handle: My Grid
          field:
            type: grid
            sets:
              video:
                fields:
                  -
                    handle: video
                    field:
                      type: video
                  -
                    handle: size
                    field:
                      options:
                        full_width: Full-width
                        large:      Large
                        medium:     Medium
                        small:      Small
                      type: radio
                      default: full_width
  ```
</details>


In a partial, I added an array to the front matter for the different variants' settings. Each key maps to one of the options from the `size` field.

```handlebars
---
video_variants:
  small:
    outer_wrapper_class: relative w-40vw
    inner_wrapper_class: h-0 aspect-ratio-16x9
    iframe_class:        absolute w-full h-full -mt-8
  medium:
    outer_wrapper_class: relative w-60vw
    inner_wrapper_class: h-0 aspect-ratio-16x9
    iframe_class:        absolute w-full h-full -mt-8
  large:
    outer_wrapper_class: relative w-75vw
    inner_wrapper_class: h-0 aspect-ratio-16x9
    iframe_class:        absolute w-full h-full -mt-4
  full_width:
    outer_wrapper_class: w-full h-full
    inner_wrapper_class: w-full h-full
    iframe_class:        object-cover w-full h-full
---




<div class="flex items-center justify-center w-full h-screen">
  <div class="{{ array_get:view:video_variants key='{size}.outer_wrapper_class' }}">
    <div class="{{ array_get:view:video_variants key='{size}.inner_wrapper_class' }}">
      <iframe
        allowfullscreen
        src         ="{{ video | embed_url }}"
        frameborder ="0"
        allow       ="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        class       ="{{ array_get:view:video_variants key='{size}.iframe_class' }}"
      ></iframe>
    </div>
  </div>
</div>

```

## Parameters
### `key`
Dot-syntax key-path to the value.

You only *need* the `key` param if one or more keys in the path come from a variable. For me, this often comes from user-generated content or a parameter passed to the partial.

### `default`
This value serves as the fallback if the key-path doesn't exist.
