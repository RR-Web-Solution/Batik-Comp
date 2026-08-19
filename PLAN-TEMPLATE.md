# {Target} — Implementation Plan Template

> **AI-Agent Edition.** This is a generic, resumable project plan template. When the user says
> *"read this template and plan {target}"*, read this file, then produce a filled-in plan by
> replacing every `{{…}}` placeholder below with target-specific content. Keep this template as the
> master; save the filled plan as `{target}-plan.md`.
>
> **Worked example:** `Expand-plan.md` in this repository is a completed plan built from this
> template — read it to see how each section and phase was filled in for a real target
> (a Laravel web app), including a populated tracker and session notes.

---

## 0. How to Use This Template (Agent Rules)

1. **Planning pass (one session).** When given a target, first write the plan — sections §1–§9. Do
   not start building yet unless the user explicitly says so.
2. **Placeholders.** Every `{{…}}` must be replaced. If a section does not apply, write `N/A` — do
   not delete the section.
3. **Sizing.** Split work into **phases**, each small enough to fit one session and ordered so each
   phase's *Entry check* (prerequisites) is satisfiable. Never start a phase whose Entry check is unmet.
4. **Trackers.** Update the **Status at a Glance** table (§2) after every session: set the working
   phase `in progress` with a `Started` date, tick `- [ ]` boxes as you complete them, and on
   completion mark it `done` with `Finished` + notes.
5. **One phase per session.** Unless the user says "do all phases" / "continue", work on **only one
   phase at a time**, then stop and report. When resuming with several phases already part-built on
   disk from a prior session, still work one phase at a time: finish + verify them in tracker order
   (each gates the next), but only treat the `in progress` phase as the one you actively build on —
   do not start a later phase whose Entry check is unmet.
6. **Never skip verification.** Every phase ends with a `Verify` command list. Run them. Do not mark
   a phase done if any command fails.
7. **Respect locked decisions.** §3 is binding. Do not introduce alternative tooling or change the
   architecture without an explicit user decision.
8. **Ask before expanding scope.** Anything not in the plan goes to §13 (Backlog), not into the build.
9. **Check out.** On finish: update tracker, tick boxes, leave a clean-working-tree note (commit only
   if the user asks).

---

## 1. Target & Mission

**Target:** {{one-line description of what to build}}

**Goals:**
1. {{goal}}
2. {{goal}}
3. {{goal}}

---

## 2. Status at a Glance (TRACKER — update after every session)

| Phase | Title | Status | Started | Finished | Session notes |
|-------|-------|--------|---------|----------|---------------|
| 0 | {{Environment / Recon}} | `not started` | | | |
| 1 | {{First deliverable}} | `not started` | | | |
| … | {{…}} | `not started` | | | |

**Status legend:** `not started` · `in progress` · `blocked` · `done`

---

## 3. Locked Technical Decisions

| Concern | Decision |
|---|---|
| {{Framework / language}} | {{decision — e.g. version, why}} |
| {{Database}} | {{decision}} |
| {{Front end / styling}} | {{decision}} |
| {{Build tooling}} | {{decision — e.g. "none / existing tool only"}} |
| {{Auth}} | {{decision}} |
| {{Validation}} | {{decision}} |
| {{Data / content model}} | {{decision}} |
| {{Design source}} | {{decision}} |

> These are binding. Changes require an explicit user decision.

---

## 4. Current State (Inventory)

- {{What already exists: files, services, dependencies}}
- {{What's missing / what must be built}}
- {{Any existing prototype or canonical reference}}
- {{Current routes/entry points and their state}}

---

## 5. Target Map

### {{Public / core surfaces}}
| {{Route / URL / endpoint}} | {{Handler / view}} | Purpose |
|---|---|---|
| `{{path}}` | {{handler}} | {{purpose}} |
| `{{path}}` | {{handler}} | {{purpose}} |

### {{Protected / admin surfaces}}
| {{Route / URL / endpoint}} | {{Handler / view}} | Purpose |
|---|---|---|
| `{{path}}` | {{handler}} | {{purpose}} |

### Error states
- {{e.g. 403, 404, 5xx — how they should behave / look}}

---

## 6. Target File & Route Structure

```
{{top-level project root}}/
├── {{area}}/
│   ├── {{file}}          # {{purpose}}
│   └── {{file}}          # {{purpose}}
├── {{area}}/
│   └── {{file}}
└── {{routes / config}}   # {{purpose}}
```

---

## 7. Data Model / Schema

### `{{table}}`
| Column | Type | Notes |
|---|---|---|
| `{{col}}` | {{type}} | {{notes}} |
| `{{col}}` | {{type}} | {{notes}} |

### 7.1 Structured content / nested payloads
{{describe any JSON/blob shapes, enum values, or conventions — e.g. a `content` column storing
sections that the view renders generically}}

---

## 8. Design Conventions & Reuse

- {{Master layout / template: head assets, nav, footer, `@yield`/`@section` blocks}}
- {{Reuse: which existing markup/classes/components are canonical}}
- {{Nav/active-state behaviour}}
- {{Flash / notification conventions}}
- {{Naming: all routes named, controller conventions, etc.}}

---

## 9. Phases

Each phase = a session unit. **Goal** = what it achieves. **Entry check** = prerequisites.
**Exit criteria** = what "done" means. **Verify** = commands the agent must run before checking out.

> Copy the block below per phase and fill in. Number phases 0, 1, 2, … in build order.

---

### Phase N — {{Title}}

**Goal:** {{one or two sentences}}

**Entry check:** {{prior phase done / specific prerequisite}}

Steps:
- [ ] {{step}}
- [ ] {{step}}

**Verify:**
- [ ] {{command / observable outcome}}
- [ ] {{command / observable outcome}}

**Exit criteria:** {{one sentence}}. Phase N `done`.

---

## 10. Session Playbook (Resumability)

Every session, follow this loop:

1. Read §2 tracker → find `in progress` (or next `not started`) phase.
2. `git status` → confirm working tree matches last session's notes.
3. Set phase status `in progress` + `Started` date.
4. Work the unchecked `- [ ]` steps in order. Never start a phase whose Entry check is unmet.
5. Run the phase's `Verify` commands. Fix failures before moving on.
6. Update tracker (`done` / `blocked` + notes), tick completed boxes, then summarize to the user:
   what changed, what's next, any decisions needing their input.

> If a phase cannot finish in one session, leave it `in progress`, check off the steps that ARE
> complete, and note precisely which step to continue from. Do NOT start a later phase.

---

## 11. Definition of Done (Global)

- Every checklist item in the phase is ticked and every `Verify` command passes.
- Locked technical decisions (§3) respected; no unapproved tooling introduced.
- Code follows the project's existing conventions (style, structure, validation, services).
- Test/lint commands defined in the plan all pass.
- Tracker in §2 is current and honest.

---

## 12. Risks & Open Questions

| Risk / Question | Mitigation / Decision needed |
|---|---|
| {{risk or question}} | {{mitigation / who decides}} |
| {{risk or question}} | {{mitigation / who decides}} |

---

## 13. Beyond Scope (Backlog — do NOT build unless asked)

- [ ] {{deferred item}}
- [ ] {{deferred item}}

---

## 14. Handoff Checklist (final phase)

- [ ] Write a `DEPLOYMENT.md` or equivalent: env vars, build/migrate/seed commands, cache clears, web server notes.
- [ ] Confirm static/legacy assets are superseded or kept as reference — **ask the user first**.
- [ ] Final `git` state: clean, single handoff commit if the user approves.
- [ ] Update the README with run instructions.
- [ ] Verify a production-like run (debug off) shows styled error pages, not stack traces.
