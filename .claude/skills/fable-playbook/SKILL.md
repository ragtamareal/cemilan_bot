---
name: fable-playbook
description: Working method for planning a task, breaking it into steps, and checking your own work before reporting. Use at the start of any non-trivial task (multi-file change, bug hunt, migration, new feature, research question) and again before you say something is done.
---

# Fable playbook

A working method handed over from the previous model on this project. It is
not a checklist to recite; it is the order in which to think. Scale it to the
task: a one-line fix needs thirty seconds of this, a migration needs all of it.

## 1. Before planning: find out what is actually being asked

- Restate the request in one sentence, in your own words. If you cannot, you
  do not understand it yet. Read more before you ask the user anything.
- Separate the **goal** (what the user wants to be true afterwards) from the
  **instruction** (what they literally typed). Serve the goal; if the two
  conflict, say so instead of silently picking one.
- Decide what "done" looks like in observable terms: a command that passes, a
  page that renders, a number that matches. Write it down. This is what you
  will check in section 4.
- Ask the user only for decisions that are theirs: scope, trade-offs with
  real cost, anything destructive or outward-facing. Everything you can learn
  from the code, learn from the code.

## 2. Planning: look first, then commit to a route

- **Read before you design.** Open the files the change touches, their
  callers, and one existing example of the same kind of thing in this repo.
  The codebase's own conventions outrank your defaults.
- **Verify assumptions that the plan rests on.** "This function is only called
  from here", "this config is loaded at boot", "this library supports X":
  each one is a grep or a quick run away from being a fact. A plan built on an
  unchecked guess fails late and expensively.
- **Pick one route and say why.** Consider alternatives briefly, then choose.
  Prefer the smallest change that fully reaches the goal. Do not add
  abstraction, options, or cleanup nobody asked for.
- **Name the risky part.** Every task has one step where you are least sure.
  Identify it and do it first, or prototype it, so that a dead end costs
  minutes instead of the whole session.
- When you have enough information to act, act. Do not re-derive settled
  facts or re-open decisions the user already made.

## 3. Breaking the work into steps

- Each step should leave the project in a working state and be checkable on
  its own. If you cannot say how you would verify a step, it is too big or
  too vague: split it.
- Order steps by dependency, then by risk (uncertain ones early).
- Run independent lookups in parallel (reads, searches, status checks).
  Sequence anything where one result decides the next action.
- Change one thing at a time when debugging. Two simultaneous changes and a
  different result tell you nothing.
- Keep a short running list for longer tasks: done, in progress, still to do,
  and anything you noticed but deliberately left alone. Update it as facts
  change; a plan is a tool, not a promise.
- When reality disagrees with the plan, stop and re-plan. Do not push a
  failing approach harder. Three failed attempts at the same idea means the
  idea is wrong, not the execution.
- Stay in scope. If you find an unrelated bug, note it for the report; do not
  fix it unasked.

## 4. Checking your own work

Assume the first version has a mistake in it. Your job is to find it before
the user does.

- **Run it.** Code that was never executed is a draft. Run the tests, the
  linter, the build, and the actual feature. For a bug fix, reproduce the bug
  first, then show it is gone.
- **Check against the "done" definition from section 1**, not against your
  memory of what you meant to do.
- **Reread the full diff** as a reviewer who distrusts the author. Look for:
  leftover debug output, edits to files you did not mean to touch, a renamed
  thing still referenced by its old name, error paths, empty and boundary
  inputs, and anything the change breaks for other callers.
- **Trace one real example end to end** through the changed code by hand.
  Passing tests prove only what the tests cover.
- **Root cause, not symptom.** If a fix works and you cannot explain why the
  bug happened, you are not finished. Never make a check pass by weakening
  it: no skipped tests, loosened assertions, or swallowed errors.
- **Distinguish what you verified from what you believe.** "Tests pass" means
  you ran them and saw the output this session. Anything else is "should
  work, not run", and gets reported that way.
- Before any delete, overwrite, force-push, or message to the outside world:
  look at the target, and confirm with the user unless they already said to
  go ahead.

## 5. Reporting

- Lead with the outcome: what now works, or what does not and why.
- State plainly what was verified and how, what was not verified, and what
  was skipped. A failed test is reported with its output, not softened.
- Mention decisions you made on the user's behalf and anything you noticed
  outside scope.
- Keep it short. The user wants the result and the caveats, not a diary.

## When you are stuck

1. Re-read the exact error text and the exact request. The answer is often in
   a word you skimmed.
2. Shrink the problem: smallest input, fewest files, one command that shows
   the failure.
3. Question the assumption you are most sure of, and check it directly.
4. If you are still blocked, tell the user what you tried, what you learned,
   and the specific thing you need. Do not guess and present it as a result.
