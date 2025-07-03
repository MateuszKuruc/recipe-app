<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import LinkButton from '@/components/LinkButton.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    categories: Array,
    tags: Array,
    recipe: Object,
});

const form = useForm({
    category_id: String(props.recipe?.category_id) ?? '',
    title: props.recipe?.title ?? '',
    excerpt: props.recipe?.excerpt ?? '',
    ingredients: props.recipe?.ingredients ?? '',
    prepare_time: props.recipe?.prepare_time ?? '',
    cooking_time: props.recipe?.cooking_time ?? '',
    servings: props.recipe?.servings ?? '',
    instructions: props.recipe?.instructions ?? '',
    main_image: null,
    secondary_image: null,
    tags: props.recipe?.tags?.map((tag) => tag.id) ?? [],
});

const mainImagePreview = ref(null);
const secondaryImagePreview = ref(null);

const isEditing = props.recipe !== undefined && props.recipe !== null;

if (isEditing && props.recipe?.main_image) {
    mainImagePreview.value = `/storage/${props.recipe.main_image}`;
}
if (isEditing && props.recipe?.secondary_image) {
    secondaryImagePreview.value = `/storage/${props.recipe.secondary_image}`;
}

const submit = () => {
    if (!validateStep3()) {
        return;
    }

    const url = isEditing ? route('recipes.update', props.recipe.slug) : route('recipes.store');

    const method = isEditing ? 'put' : 'post';

    const hasFileUploads = form.main_image !== null || form.secondary_image !== null;

    form.post(url, {
        method: method,
        forceFormData: hasFileUploads,
        onSuccess: () => {
            form.reset();
            if (method === 'post') {
            toast.success('Dodano nowy przepis')
            } else if (method === 'put') {
                toast.success('Przepis został edytowany')
            }
        },
        onError: () => {
            toast.error('Wystąpił błąd. Przepis nie został utworzony')
        }
    });
};

const currentStep = ref(1);
const maxStep = 3;

const validateStep1 = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.category_id) {
        form.setError('category_id', 'Wybierz kategorię');
        hasError = true;
    }
    if (!form.title) {
        form.setError('title', 'Podaj nazwę przepisu');
        hasError = true;
    }
    if (!form.excerpt) {
        form.setError('excerpt', 'Podaj krótki opis');
        hasError = true;
    }

    return !hasError;
};

const validateStep2 = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.ingredients) {
        form.setError('ingredients', 'Dodaj składniki');
        hasError = true;
    }
    if (form.prepare_time === null || form.prepare_time === undefined || form.prepare_time === '') {
        form.setError('prepare_time', 'Podaj czas przygotowania');
        hasError = true;
    }
    if (form.cooking_time === null || form.cooking_time === undefined || form.cooking_time === '') {
        form.setError('cooking_time', 'Podaj czas gotowania');
        hasError = true;
    }
    if (!form.servings) {
        form.setError('servings', 'Wybierz liczbę porcji');
        hasError = true;
    }

    return !hasError;
};

const validateStep3 = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.instructions) {
        form.setError('instructions', 'Dodaj instrukcję');
        hasError = true;
    }
    if (!isEditing && !form.main_image) {
        form.setError('main_image', 'Dodaj zdjęcie dania');
        hasError = true;
    }

    return !hasError;
};

const handleNextStep = () => {
    if (currentStep.value === 1) {
        if (validateStep1()) {
            currentStep.value++;
        }
    } else if (currentStep.value === 2) {
        if (validateStep2()) {
            currentStep.value++;
        }
    } else if (currentStep.value === 3) {
        if (validateStep3()) {
            submit();
        }
    }
};

const handleMainImageUpload = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.main_image = file;
        mainImagePreview.value = URL.createObjectURL(file);
    }
};

const handleSecondaryImageUpload = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.secondary_image = file;
        secondaryImagePreview.value = URL.createObjectURL(file);
    }
};

console.log('Categories:', props.categories);
console.log('Tags:', props.tags);
console.log(form.prepare_time);
</script>

<template>
    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <div v-if="currentStep === 1" class="grid gap-6">
            <div>
                <h2 class="mb-2 font-semibold">Tagi</h2>

                <div class="flex flex-col gap-2">
                    <div v-for="tag in tags" :key="tag.id" class="flex items-center gap-2">
                        <input type="checkbox" :id="`tag-${tag.id}`" :value="tag.id" v-model="form.tags" />
                        <label :for="`tag-${tag.id}`">{{ tag.name }}</label>
                    </div>
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="category">Kategoria</Label>

                <Select v-model="form.category_id">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Wybierz kategorię" />
                        <!--                <SelectValue :placeholder="form.category_id" />-->
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem v-for="category in categories" :key="category.id" :value="String(category.id)">
                            {{ category.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>

                <InputError :message="form.errors.category_id" />
            </div>

            <div class="grid gap-2">
                <Label for="title">Nazwa</Label>
                <Input id="title" type="text" required v-model="form.title" placeholder="Pizza" />
                <InputError :message="form.errors.title" />
            </div>

            <div class="grid gap-2">
                <Label for="excerpt">Krótki opis</Label>

                <Textarea id="excerpt" v-model="form.excerpt" placeholder="Napisz kilka słów o przepisie" class="h-24" />

                <InputError :message="form.errors.excerpt" />
            </div>
        </div>
        <div v-if="currentStep === 2" class="grid gap-6">
            <div class="grid gap-2">
                <Label for="excerpt">Składniki</Label>

                <Textarea id="ingredients" v-model="form.ingredients" placeholder="300g kurczaka, 2 papryki..." class="h-24" />

                <InputError :message="form.errors.ingredients" />
            </div>

            <div class="grid gap-2">
                <Label for="prepare_time">Czas przygotowania</Label>

                <Select v-model="form.prepare_time">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Wybierz wartość" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="0">0 min</SelectItem>
                        <SelectItem :value="5">5 min</SelectItem>
                        <SelectItem :value="15">15 min</SelectItem>
                        <SelectItem :value="30">30 min</SelectItem>
                        <SelectItem :value="45">45 min</SelectItem>
                        <SelectItem :value="60">1 godz.</SelectItem>
                        <SelectItem :value="90">1 godz. 30 min</SelectItem>
                        <SelectItem :value="120">ponad 2 godz.</SelectItem>
                    </SelectContent>
                </Select>

                <InputError :message="form.errors.prepare_time" />
            </div>

            <div class="grid gap-2">
                <Label for="cooking_time">Czas gotowania</Label>

                <Select v-model="form.cooking_time">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Wybierz wartość" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="0">0 min</SelectItem>
                        <SelectItem :value="5">5 min</SelectItem>
                        <SelectItem :value="15">15 min</SelectItem>
                        <SelectItem :value="30">30 min</SelectItem>
                        <SelectItem :value="45">45 min</SelectItem>
                        <SelectItem :value="60">1 godz.</SelectItem>
                        <SelectItem :value="75">1 godz. 15 min</SelectItem>
                        <SelectItem :value="90">1 godz. 30 min</SelectItem>
                        <SelectItem :value="120">ponad 2 godz.</SelectItem>
                    </SelectContent>
                </Select>

                <InputError :message="form.errors.cooking_time" />
            </div>

            <div class="grid gap-2">
                <Label for="servings">Liczba porcji</Label>

                <Select v-model="form.servings">
                    <SelectTrigger class="w-full">
                        <SelectValue placeholder="Wybierz wartość" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="1">dla 1 osoby</SelectItem>
                        <SelectItem :value="2">dla 2 osób</SelectItem>
                        <SelectItem :value="3">dla 3 osób</SelectItem>
                        <SelectItem :value="4">dla 4 osób</SelectItem>
                        <SelectItem :value="5">dla 5 osób</SelectItem>
                        <SelectItem :value="6">dla 6 osób</SelectItem>
                    </SelectContent>
                </Select>

                <InputError :message="form.errors.servings" />
            </div>
        </div>
        <div v-if="currentStep === 3" class="grid gap-6">
            <div class="grid gap-2">
                <Textarea id="instructions" v-model="form.instructions" placeholder="Opisz wszystkie kroki" class="h-24" />
                <InputError :message="form.errors.instructions" />
            </div>

            <div class="grid gap-2">
                <Label for="main_image">Zdjęcie główne</Label>
                <img v-if="mainImagePreview" :src="mainImagePreview" class="h-16 w-16 object-cover" />
                <Input id="main_image" type="file" @change="handleMainImageUpload" />
                <InputError :message="form.errors.main_image" />
            </div>

            <div class="grid gap-2">
                <Label for="secondary_image">Zdjęcie dodatkowe</Label>
                <img v-if="secondaryImagePreview" :src="secondaryImagePreview" class="h-16 w-16 object-cover" />
                <Input id="secondary_image" type="file" @change="handleSecondaryImageUpload" />
                <InputError :message="form.errors.secondary_image" />
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <!-- Left-side actions -->
            <div class="flex gap-2">
                <LinkButton variant="outline" v-if="props.recipe" :href="route('recipes.show', recipe.slug)"> Anuluj </LinkButton>

                <LinkButton variant="outline" v-if="!props.recipe" :href="route('recipes.index')"> Anuluj </LinkButton>

                <Button v-if="currentStep > 1" @click="currentStep--" variant="default" type="button">Wstecz</Button>
            </div>

            <div class="flex gap-2">
                <Button v-if="currentStep < maxStep" @click="handleNextStep" type="button">Dalej</Button>
                <Button v-if="currentStep === maxStep" type="submit" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                    {{ props.recipe ? 'Aktualizuj przepis' : 'Dodaj przepis' }}
                </Button>
            </div>
        </div>
    </form>
</template>
