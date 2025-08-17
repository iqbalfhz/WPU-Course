<x-layout :title="$title">
    <main class="relative isolate bg-white dark:bg-zinc-950">
        <!-- HERO -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl pt-20 pb-14 lg:pt-28 lg:pb-20 text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">Contact</h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-400">Have a project in mind or just
                    want to say hi? Fill the form—I'll reply soon.</p>
            </div>
        </section>

        <!-- FORM + INFO with tabs: Quick Message / Project Brief -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl grid gap-10 lg:grid-cols-12" x-data="{ tab: 'quick' }">
                <div class="lg:col-span-8">
                    <div class="inline-flex rounded-xl border border-gray-200 dark:border-white/10 p-1 mb-4">
                        <button @click="tab='quick'"
                            :class="tab === 'quick' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
                                'text-gray-600 dark:text-gray-300'"
                            class="px-3 py-1.5 rounded-lg text-sm">Quick message</button>
                        <button @click="tab='brief'"
                            :class="tab === 'brief' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' :
                                'text-gray-600 dark:text-gray-300'"
                            class="px-3 py-1.5 rounded-lg text-sm">Project brief</button>
                    </div>

                    <!-- QUICK MESSAGE FORM -->
                    <div x-show="tab==='quick'" x-transition>
                        <div
                            class="bg-white dark:bg-zinc-900 shadow-lg rounded-3xl p-8 ring-1 ring-gray-200 dark:ring-white/10">
                            <form action="#" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="_form" value="quick">
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('name')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('email')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                    <textarea name="message" rows="5" required
                                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-between">
                                    <label
                                        class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <input type="checkbox" name="consent"
                                            class="rounded border-gray-300 dark:border-white/10 text-indigo-600 focus:ring-indigo-500">
                                        I agree to the privacy policy
                                    </label>
                                    <button type="submit"
                                        class="inline-flex items-center rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 text-sm font-semibold shadow">Send</button>
                                </div>
                                {{-- Honeypot --}}<input type="text" name="website" class="hidden" tabindex="-1"
                                    autocomplete="off">
                            </form>
                        </div>
                    </div>

                    <!-- PROJECT BRIEF FORM -->
                    <div x-show="tab==='brief'" x-transition>
                        <div
                            class="bg-white dark:bg-zinc-900 shadow-lg rounded-3xl p-8 ring-1 ring-gray-200 dark:ring-white/10">
                            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                <input type="hidden" name="_form" value="brief">
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Budget</label>
                                        <select name="budget"
                                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="<5m">&lt; Rp5 juta</option>
                                            <option value="5-15m">Rp5–15 juta</option>
                                            <option value=">15m">&gt; Rp15 juta</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Timeline</label>
                                        <select name="timeline"
                                            class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                            <option>2–4 weeks</option>
                                            <option>1–2 months</option>
                                            <option>Flexible</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project
                                        goals</label>
                                    <textarea name="goals" rows="4"
                                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">{{ old('goals') }}</textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachments
                                        (optional)</label>
                                    <input type="file" name="attachment"
                                        class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-900 file:text-white dark:file:bg-white dark:file:text-gray-900 file:px-4 file:py-2 hover:file:opacity-90" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <label
                                        class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <input type="checkbox" name="consent"
                                            class="rounded border-gray-300 dark:border-white/10 text-indigo-600 focus:ring-indigo-500">
                                        I agree to the privacy policy
                                    </label>
                                    <button type="submit"
                                        class="inline-flex items-center rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 text-sm font-semibold shadow">Send
                                        brief</button>
                                </div>
                                {{-- Honeypot --}}<input type="text" name="website" class="hidden"
                                    tabindex="-1" autocomplete="off">
                                {{-- reCAPTCHA placeholder --}}{{-- <div class="g-recaptcha" data-sitekey="YOUR_KEY"></div> --}}
                            </form>
                        </div>
                    </div>
                </div>

                <!-- CONTACT INFO -->
                <aside class="lg:col-span-4">
                    <div class="rounded-3xl bg-gray-50 dark:bg-white/5 p-6 ring-1 ring-gray-200 dark:ring-white/10">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contact information</h2>
                        <ul class="mt-4 space-y-3 text-sm text-gray-700 dark:text-gray-300">
                            <li class="flex items-center gap-3"><span
                                    class="h-2 w-2 rounded-full bg-emerald-500"></span> Available for freelance</li>
                            <li><strong>Email:</strong> <a href="mailto:you@mail.com"
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline">you@mail.com</a></li>
                            <li><strong>Phone:</strong> +62 812-3456-7890</li>
                            <li><strong>Location:</strong> Indonesia (GMT+7)</li>
                        </ul>
                        <div class="mt-6 flex items-center gap-4 text-gray-500 dark:text-gray-400">
                            <a href="https://github.com/yourusername"
                                class="hover:text-gray-900 dark:hover:text-white" aria-label="GitHub">Github</a>
                            <a href="https://www.linkedin.com/in/yourusername"
                                class="hover:text-gray-900 dark:hover:text-white" aria-label="LinkedIn">LinkedIn</a>
                            <a href="mailto:you@mail.com" class="hover:text-gray-900 dark:hover:text-white"
                                aria-label="Email">Email</a>
                        </div>
                        <div
                            class="mt-6 aspect-video overflow-hidden rounded-xl ring-1 ring-gray-200 dark:ring-white/10">
                            {{-- Optional map embed --}}
                            <iframe src="https://www.google.com/maps?q=Jakarta&output=embed" width="100%"
                                height="100%" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
                            By sending this form you agree to the processing of your data as described in the privacy
                            policy.
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </main>
</x-layout>
