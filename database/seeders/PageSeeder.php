<?php

namespace Database\Seeders;

use App\Nova\Services\NovaPage\Models\StaticPage;
use App\Providers\NovaServiceProvider;
use Database\Seeders\Concerns\CopiesSeedImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

/**
 * Seeds the Nova pages (App\Nova\Templates) with the site's launch content in hy, ru and en,
 * and copies their photos from database/seeders/images/site to the public disk for the file manager.
 *
 * Pages that already exist are left alone, so content edited in Nova is never overwritten.
 * To reseed one, delete its row from static_pages and run: php artisan db:seed --class=PageSeeder
 */
class PageSeeder extends Seeder
{
    use CopiesSeedImages;

    public function run(): void
    {
        foreach ($this->pages() as $name => $page) {
            if (StaticPage::where('name', $name)->exists()) {
                $this->command?->warn("  {$name} already exists, skipped.");

                continue;
            }

            StaticPage::create([
                'type' => 'route',
                'name' => $name,
                'title' => $page['title'],
                'is_indexable' => true,
                'meta_title' => $page['meta_title'],
                'meta_description' => $page['meta_description'],
                'attributes' => json_encode($page['attributes'] + [
                    'title' => $page['title'],
                    'is_indexable' => true,
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'meta_keywords' => null,
                    'meta_image' => null,
                ], JSON_UNESCAPED_UNICODE),
            ]);

            Cache::forget("static_page_{$name}");
            $this->command?->info("  {$name} seeded.");
        }

        $missing = array_diff(array_keys(NovaServiceProvider::PAGES), array_keys($this->pages()));
        if ($missing) {
            $this->command?->warn('  No seed content for: '.implode(', ', $missing));
        }
    }

    /**
     * A Flexible field value: one group per item, in the format Whitecube\NovaFlexibleContent stores.
     */
    protected function flexible(string $layout, array $items): array
    {
        return array_map(fn (array $attributes) => [
            'layout' => $layout,
            'key' => bin2hex(random_bytes(8)),
            'attributes' => $attributes,
        ], $items);
    }

    protected function pages(): array
    {
        return [
            'home-page' => [
                'title' => ['hy' => 'Գլխավոր', 'ru' => 'Главная', 'en' => 'Home'],
                'meta_title' => ['hy' => 'I MUST մարքեթինգային գործակալություն', 'ru' => 'I MUST, маркетинговое агентство', 'en' => 'I MUST Marketing Agency'],
                'meta_description' => ['hy' => 'Մարքեթինգ, կայքեր և վիդեո փորձառու մասնագետների մեկ թիմից՝ Երևանում։', 'ru' => 'Маркетинг, сайты и видео от одной команды опытных специалистов в Ереване.', 'en' => 'Marketing, websites and video from one team of experienced specialists in Yerevan.'],
                'attributes' => [
                    'hero_subtitle' => ['hy' => 'Ոչ թե նոր ստարտափ, այլ փորձառու մասնագետների միավորում։', 'ru' => 'Не новый стартап, а союз опытных специалистов.', 'en' => 'Not a new startup, but a union of experienced specialists.'],
                    'hero_image' => $this->image('site/home-hero.webp'),
                    'hero_image_alt' => ['hy' => 'I MUST թիմը պլանավորում է արշավը', 'ru' => 'Команда I MUST планирует кампанию', 'en' => 'The I MUST team planning a campaign'],
                    'team_title' => ['hy' => 'Մարքեթոլոգներ, ծրագրավորող և ռիլսմեյքերներ։ Մեկ թիմ։', 'ru' => 'Маркетологи, разработчик и рилсмейкеры. Одна команда.', 'en' => 'Marketers, a developer and reelmakers. One team.'],
                    'team_lead' => ['hy' => 'Ռազմավարությունը, կայքը և վիդեոն պլանավորում ենք միասին, որպեսզի բոլոր ալիքները պատմեն նույն պատմությունը։', 'ru' => 'Стратегию, сайт и видео мы планируем вместе, поэтому все каналы рассказывают одну историю.', 'en' => 'Strategy, websites and video are planned together, so every channel tells the same story.'],
                    'team_roles' => $this->flexible('role', [
                        [
                            'title' => ['hy' => 'Մարքեթոլոգներ', 'ru' => 'Маркетологи', 'en' => 'Marketers'],
                            'text' => ['hy' => 'Ռազմավարություն, բովանդակություն և թիրախային գովազդ։', 'ru' => 'Стратегия, контент и таргетированная реклама.', 'en' => 'Strategy, content and targeted ads.'],
                            'image' => $this->image('site/home-role-marketing.webp'),
                            'image_alt' => ['hy' => 'Մարքեթինգային ռազմավարության քննարկում', 'ru' => 'Обсуждение маркетинговой стратегии', 'en' => 'Marketing strategy session'],
                        ],
                        [
                            'title' => ['hy' => 'Full-stack ծրագրավորող', 'ru' => 'Full-stack разработчик', 'en' => 'Full-stack developer'],
                            'text' => ['hy' => 'Եռալեզու կայքեր՝ հիմնական SEO-ով։', 'ru' => 'Трёхъязычные сайты с базовым SEO.', 'en' => 'Trilingual websites with basic SEO.'],
                            'image' => $this->image('site/home-role-developer.webp'),
                            'image_alt' => ['hy' => 'Կայքի մշակում', 'ru' => 'Разработка сайта', 'en' => 'Website development'],
                        ],
                        [
                            'title' => ['hy' => 'Ռիլսմեյքերներ', 'ru' => 'Рилсмейкеры', 'en' => 'Reelmakers'],
                            'text' => ['hy' => 'Վիդեոյի նկարահանում և մոնտաժ։', 'ru' => 'Съёмка и монтаж видео.', 'en' => 'Video shooting and editing.'],
                            'image' => $this->image('site/home-role-reels.webp'),
                            'image_alt' => ['hy' => 'Վիդեո նկարահանում', 'ru' => 'Видеосъёмка', 'en' => 'Video shoot in progress'],
                        ],
                    ]),
                    'packages_title' => ['hy' => 'Մեզ հետ աշխատելու երեք ձև', 'ru' => 'Три формата работы с нами', 'en' => 'Three ways to work with us'],
                    'studio_title' => ['hy' => 'Հաջորդ քայլը՝ I MUST Studio', 'ru' => 'Следующий шаг: студия I MUST', 'en' => 'Next: the I MUST Studio'],
                    'studio_lead' => ['hy' => 'Կրթություն, կոնֆերանս սրահ, ֆոտոզոնաներով ստուդիայի վարձույթ և սեփական արտադրություն՝ մեկ վայրում։', 'ru' => 'Обучение, конференц-зал, аренда студии с фотозонами и собственный продакшн в одном месте.', 'en' => 'Education, a conference hall, studio rentals with photo zones and in-house production, all in one place.'],
                    'studio_image' => $this->image('site/home-studio.webp'),
                    'studio_image_alt' => ['hy' => 'Լուսանկարչական ստուդիա՝ տեղադրված լույսերով', 'ru' => 'Фотостудия с выставленным светом', 'en' => 'Photo studio with lighting set up'],
                    'cta_title' => ['hy' => 'Պատմեք մեզ ձեր բիզնեսի մասին։', 'ru' => 'Расскажите нам о своём бизнесе.', 'en' => 'Tell us about your business.'],
                    'cta_lead' => ['hy' => 'Մենք կառաջարկենք այն փաթեթը, որը համապատասխանում է ձեր այսօրվա փուլին։', 'ru' => 'Мы предложим пакет, который подходит вашему этапу.', 'en' => 'We will suggest the package that fits where you are today.'],
                ],
            ],
            'about-page' => [
                'title' => ['hy' => 'Մեր մասին', 'ru' => 'О нас', 'en' => 'About'],
                'meta_title' => ['hy' => 'I MUST-ի մասին', 'ru' => 'О компании I MUST', 'en' => 'About I MUST'],
                'meta_description' => ['hy' => 'Ծանոթացեք I MUST մարքեթինգային գործակալության հիմնադիրներին, ծրագրավորողներին և գործընկերներին։', 'ru' => 'Основатели, разработчики и партнёры маркетингового агентства I MUST.', 'en' => 'Meet the founders, developers and partners behind I MUST Marketing Agency.'],
                'attributes' => [
                    'hero_eyebrow' => ['hy' => 'Մեր մասին', 'ru' => 'О нас', 'en' => 'About us'],
                    'hero_title' => ['hy' => 'Մենք զրոյից չենք սկսել։', 'ru' => 'Мы начинали не с нуля.', 'en' => 'We didn\'t start from zero.'],
                    'hero_lead' => ['hy' => 'I MUST-ից առաջ մեզանից յուրաքանչյուրը կարիերա էր կառուցել իր ոլորտում։ Այժմ աշխատում ենք մեկ անվան ներքո։', 'ru' => 'До I MUST каждый из нас построил карьеру в своей сфере. Теперь мы работаем под одним именем.', 'en' => 'Each of us built a career in our field before I MUST. Now we work under one name.'],
                    'hero_image' => $this->image('site/about-hero.webp'),
                    'hero_image_alt' => ['hy' => 'I MUST թիմը գրասենյակում', 'ru' => 'Команда I MUST в офисе', 'en' => 'The I MUST team at the office'],
                    'equation_hint' => ['hy' => 'Ընտրեք ուղղությունը՝ ծանոթանալու այն ղեկավարող հիմնադրին։', 'ru' => 'Выберите направление, чтобы познакомиться с основателем, который его ведёт.', 'en' => 'Select a discipline to meet the founder who leads it.'],
                    'structure_title' => ['hy' => 'Հիբրիդային թիմ՝ ձեր նախագծի շուրջ', 'ru' => 'Гибридная команда под ваш проект', 'en' => 'A hybrid team, built around your project'],
                    'structure_lead' => ['hy' => 'Մեկ առաջադրանք, մեկ թիմ։ Առանց գործակալությունների միջև փոխանցումների։', 'ru' => 'Одно техзадание, одна команда. Никаких передач между агентствами.', 'en' => 'One brief, one team. No handoffs between agencies.'],
                    'structure_roles' => $this->flexible('role', [
                        [
                            'title' => ['hy' => 'Մարքեթոլոգներ', 'ru' => 'Маркетологи', 'en' => 'Marketers'],
                            'text' => ['hy' => 'Մշակում են ռազմավարությունը, գրում բովանդակությունը և վարում թիրախային արշավներ։', 'ru' => 'Разрабатывают стратегию, пишут контент и запускают таргетированные кампании.', 'en' => 'Plan the strategy, write the content and run targeted campaigns.'],
                        ],
                        [
                            'title' => ['hy' => 'Full-stack ծրագրավորող', 'ru' => 'Full-stack разработчик', 'en' => 'Full-stack developer'],
                            'text' => ['hy' => 'Նախագծում և ստեղծում է եռալեզու կայքեր՝ հիմնական SEO-ով։', 'ru' => 'Проектирует и создаёт трёхъязычные сайты с базовым SEO.', 'en' => 'Designs and builds trilingual websites with basic SEO.'],
                        ],
                        [
                            'title' => ['hy' => 'Ռիլսմեյքերներ', 'ru' => 'Рилсмейкеры', 'en' => 'Reelmakers'],
                            'text' => ['hy' => 'Նկարահանում և մոնտաժում են ռիլսեր, գովազդներ և բրենդային վիդեոներ։', 'ru' => 'Снимают и монтируют рилсы, рекламу и видео для бренда.', 'en' => 'Shoot and edit reels, ads and brand videos.'],
                        ],
                    ]),
                    'founders_eyebrow' => ['hy' => 'Հիմնադիրներ', 'ru' => 'Основатели', 'en' => 'Founders'],
                    'founders_title' => ['hy' => 'Մարդիկ, ովքեր ղեկավարում են աշխատանքը', 'ru' => 'Люди, которые ведут работу', 'en' => 'The people who lead the work'],
                    'founders' => $this->flexible('founder', [
                        [
                            'discipline' => ['hy' => 'Մարքեթինգ', 'ru' => 'Маркетинг', 'en' => 'Marketing'],
                            'name' => ['hy' => 'Հիմնադրի անունը', 'ru' => 'Имя основателя', 'en' => 'Founder name'],
                            'position' => ['hy' => 'Համահիմնադիր, մարքեթինգի տնօրեն', 'ru' => 'Сооснователь, директор по маркетингу', 'en' => 'Co-founder, Marketing Director'],
                            'bio' => ['hy' => 'Ղեկավարում է ռազմավարությունը, սոցցանցերը և թիրախային գովազդը՝ առաջին գրառումից մինչև չափելի վաճառքներ։', 'ru' => 'Отвечает за стратегию, соцсети и таргетированную рекламу, от первого поста до измеримых продаж.', 'en' => 'Leads strategy, social media and targeted advertising, from the first post to measurable sales.'],
                            'photo' => null,
                            'link' => null,
                        ],
                        [
                            'discipline' => ['hy' => 'Ծրագրավորում', 'ru' => 'Разработка', 'en' => 'Development'],
                            'name' => ['hy' => 'Հիմնադրի անունը', 'ru' => 'Имя основателя', 'en' => 'Founder name'],
                            'position' => ['hy' => 'Համահիմնադիր, առաջատար full-stack ծրագրավորող', 'ru' => 'Сооснователь, ведущий full-stack разработчик', 'en' => 'Co-founder, Lead Full-stack Developer'],
                            'bio' => ['hy' => 'Ստեղծում է եռալեզու կայքեր՝ մտածված դիզայնով և SEO հիմքով, որի վրա հաճախորդները կարող են աճել։', 'ru' => 'Создаёт трёхъязычные сайты с продуманным дизайном и SEO-основой для роста клиентов.', 'en' => 'Builds trilingual websites with clean design and an SEO foundation clients can grow on.'],
                            'photo' => null,
                            'link' => null,
                        ],
                        [
                            'discipline' => ['hy' => 'Վիդեո', 'ru' => 'Видео', 'en' => 'Video'],
                            'name' => ['hy' => 'Հիմնադրի անունը', 'ru' => 'Имя основателя', 'en' => 'Founder name'],
                            'position' => ['hy' => 'Համահիմնադիր, վիդեոարտադրության ղեկավար', 'ru' => 'Сооснователь, руководитель видеопродакшна', 'en' => 'Co-founder, Head of Video Production'],
                            'bio' => ['hy' => 'Նկարահանում և մոնտաժում է ռիլսեր, գովազդներ և բրենդային պատմություններ, որոնք պահում են ուշադրությունը առաջին վայրկյանից։', 'ru' => 'Снимает и монтирует рилсы, рекламу и истории бренда, которые удерживают внимание с первой секунды.', 'en' => 'Shoots and edits reels, ads and brand stories that hold attention from the first second.'],
                            'photo' => null,
                            'link' => null,
                        ],
                    ]),
                    'network_title' => ['hy' => 'Ծրագրավորողներ և գործընկերներ', 'ru' => 'Разработчики и партнёры', 'en' => 'Developers and partners'],
                    'network_lead' => ['hy' => 'Մասնագետներ, որոնց ներգրավում ենք, երբ նախագծին ավելի շատ ձեռքեր են պետք։', 'ru' => 'Специалисты, которых мы подключаем, когда проекту нужно больше рук.', 'en' => 'Specialists we bring in when a project needs more hands.'],
                    'network_people' => $this->flexible('person', [
                        [
                            'name' => ['hy' => 'Ծրագրավորողի անունը', 'ru' => 'Имя разработчика', 'en' => 'Developer name'],
                            'role' => ['hy' => 'Ծրագրավորող', 'ru' => 'Разработчик', 'en' => 'Developer'],
                            'photo' => null,
                            'link' => null,
                        ],
                        [
                            'name' => ['hy' => 'Ծրագրավորողի անունը', 'ru' => 'Имя разработчика', 'en' => 'Developer name'],
                            'role' => ['hy' => 'Ծրագրավորող', 'ru' => 'Разработчик', 'en' => 'Developer'],
                            'photo' => null,
                            'link' => null,
                        ],
                        [
                            'name' => ['hy' => 'Գործընկերոջ անունը', 'ru' => 'Имя партнёра', 'en' => 'Partner name'],
                            'role' => ['hy' => 'Գործընկեր', 'ru' => 'Партнёр', 'en' => 'Partner'],
                            'photo' => null,
                            'link' => null,
                        ],
                        [
                            'name' => ['hy' => 'Գործընկերոջ անունը', 'ru' => 'Имя партнёра', 'en' => 'Partner name'],
                            'role' => ['hy' => 'Գործընկեր', 'ru' => 'Партнёр', 'en' => 'Partner'],
                            'photo' => null,
                            'link' => null,
                        ],
                    ]),
                    'projects_title' => ['hy' => 'Հաջողված նախագծեր', 'ru' => 'Успешные проекты', 'en' => 'Successful projects'],
                    'projects_lead' => ['hy' => 'Կայքեր, սոցցանցեր, վիդեո և գովազդ մեր հաճախորդների համար։', 'ru' => 'Сайты, соцсети, видео и реклама для наших клиентов.', 'en' => 'Websites, social media, video and advertising for our clients.'],
                    'cta_title' => ['hy' => 'Ցանկանու՞մ եք աշխատել ամբողջ թիմի հետ', 'ru' => 'Хотите работать со всей командой?', 'en' => 'Want to work with the whole team?'],
                ],
            ],
            'services-page' => [
                'title' => ['hy' => 'Ծառայություններ', 'ru' => 'Услуги', 'en' => 'Services'],
                'meta_title' => ['hy' => 'Ծառայություններ և փաթեթներ', 'ru' => 'Услуги и пакеты', 'en' => 'Services and packages'],
                'meta_description' => ['hy' => 'I MUST Start, I MUST Grow և I MUST Maintain. երեք փաթեթ՝ ձեր թվային ներկայությունը ստեղծելու, աճեցնելու և պահպանելու համար։', 'ru' => 'I MUST Start, I MUST Grow и I MUST Maintain: три пакета для создания, роста и поддержки цифрового присутствия.', 'en' => 'I MUST Start, I MUST Grow and I MUST Maintain: three packages for building, growing and maintaining your digital presence.'],
                'attributes' => [
                    'hero_eyebrow' => ['hy' => 'Ծառայություններ', 'ru' => 'Услуги', 'en' => 'Services'],
                    'hero_title' => ['hy' => 'Երեք փաթեթ։ Յուրաքանչյուրի հետևում՝ մեկ թիմ։', 'ru' => 'Три пакета. За каждым стоит одна команда.', 'en' => 'Three packages. One team behind each.'],
                    'hero_lead' => ['hy' => 'Սկսեք զրոյից, աճեք ակտիվորեն կամ պահպանեք ձեր ներկայությունը՝ նվազագույն ժամանակ ծախսելով։', 'ru' => 'Начните с нуля, растите активно или поддерживайте присутствие, почти не тратя своё время.', 'en' => 'Start from scratch, grow actively, or keep your presence maintained with minimal time from you.'],
                    'hero_image' => $this->image('site/services-hero.webp'),
                    'start_summary' => ['hy' => 'Ամբողջական թվային ներկայություն՝ զրոյից։', 'ru' => 'Полное цифровое присутствие с нуля.', 'en' => 'Complete digital presence, built from scratch.'],
                    'start_price' => ['hy' => 'Գինը՝ ըստ հարցման', 'ru' => 'Цена по запросу', 'en' => 'Price on request'],
                    'start_cadence' => ['hy' => 'Միանվագ վճար', 'ru' => 'Разовая оплата', 'en' => 'One-time fee'],
                    'start_price_note' => ['hy' => '', 'ru' => '', 'en' => ''],
                    'start_description' => ['hy' => 'Այն բիզնեսների համար, որոնք դեռ առցանց չեն կամ պետք է ճիշտ վերսկսեն։', 'ru' => 'Для бизнеса, которого ещё нет в интернете или которому нужно начать заново.', 'en' => 'For businesses that are not online yet, or need to start over properly.'],
                    'start_groups' => $this->flexible('group', [
                        [
                            'title' => ['hy' => 'Կայք', 'ru' => 'Сайт', 'en' => 'Website'],
                            'features' => ['hy' => "Եռալեզու բովանդակություն\nԱնհատական դիզայն\nՀիմնական SEO", 'ru' => "Контент на трёх языках\nИндивидуальный дизайн\nБазовое SEO", 'en' => "Trilingual content\nCustom design\nBasic SEO"],
                        ],
                        [
                            'title' => ['hy' => 'Սոցցանցերի կարգավորում', 'ru' => 'Настройка соцсетей', 'en' => 'Social media setup'],
                            'features' => ['hy' => "Facebook\nInstagram\nLinkedIn\nYouTube\nGoogle Business Profile", 'ru' => "Facebook\nInstagram\nLinkedIn\nYouTube\nGoogle Business Profile", 'en' => "Facebook\nInstagram\nLinkedIn\nYouTube\nGoogle Business Profile"],
                        ],
                    ]),
                    'grow_summary' => ['hy' => 'Ակտիվ առաջխաղացում, որը բերում է վաճառքներ։', 'ru' => 'Активное продвижение, которое приносит продажи.', 'en' => 'Active promotion that drives sales.'],
                    'grow_price' => ['hy' => 'Ֆիքսված ամսական գին', 'ru' => 'Фиксированная сумма в месяц', 'en' => 'Fixed monthly price'],
                    'grow_cadence' => ['hy' => 'Ֆիքսված ամսական վճար', 'ru' => 'Фиксированная ежемесячная оплата', 'en' => 'Monthly fixed fee'],
                    'grow_price_note' => ['hy' => '', 'ru' => '', 'en' => ''],
                    'grow_description' => ['hy' => 'Այն բիզնեսների համար, որոնք պատրաստ են ամեն ամիս ներդնել կայուն աճի մեջ։', 'ru' => 'Для бизнеса, готового каждый месяц вкладываться в стабильный рост.', 'en' => 'For businesses ready to invest in steady growth every month.'],
                    'grow_groups' => $this->flexible('group', [
                        [
                            'title' => ['hy' => 'Բովանդակություն', 'ru' => 'Контент', 'en' => 'Content'],
                            'features' => ['hy' => "Սոցցանցերի կանոնավոր բովանդակություն\nՎիդեոյի նկարահանում և մոնտաժ", 'ru' => "Регулярный контент для соцсетей\nСъёмка и монтаж видео", 'en' => "Regular social media content\nVideo shooting and editing"],
                        ],
                        [
                            'title' => ['hy' => 'Գովազդ և վերլուծություն', 'ru' => 'Реклама и аналитика', 'en' => 'Ads and analytics'],
                            'features' => ['hy' => "Google Ads\nԳովազդ Facebook-ում և Instagram-ում\nGoogle Analytics հաշվետվություններ", 'ru' => "Google Ads\nРеклама в Facebook и Instagram\nОтчёты Google Analytics", 'en' => "Google Ads\nFacebook and Instagram Ads\nGoogle Analytics reporting"],
                        ],
                    ]),
                    'maintain_summary' => ['hy' => 'Թվային ներկայության սպասարկում՝ ձեր նվազագույն ժամանակով։', 'ru' => 'Поддержка цифрового присутствия с минимумом вашего времени.', 'en' => 'Digital presence maintenance with minimal time from you.'],
                    'maintain_price' => ['hy' => '≈300 000 ֏', 'ru' => '≈300 000 драм', 'en' => '≈300,000 AMD'],
                    'maintain_cadence' => ['hy' => 'Տարեկան պայմանագիր', 'ru' => 'Годовой договор', 'en' => 'Annual contract'],
                    'maintain_price_note' => ['hy' => 'տարեկան', 'ru' => 'в год', 'en' => 'per year'],
                    'maintain_description' => ['hy' => 'Այն բիզնեսների համար, որոնց մոտ ամեն ինչ արդեն կարգավորված է և պետք է մնալ արդիական։', 'ru' => 'Для бизнеса, у которого всё уже настроено и нужно оставаться актуальным.', 'en' => 'For businesses that are already set up and want to stay current.'],
                    'maintain_groups' => $this->flexible('group', [
                        [
                            'title' => ['hy' => 'Ներառված է', 'ru' => 'Входит', 'en' => 'Included'],
                            'features' => ['hy' => "Թվային ներկայության մշտական սպասարկում\nՁեր կողմից՝ նվազագույն ժամանակ\nՄեկ տարեկան պայմանագիր", 'ru' => "Постоянная поддержка цифрового присутствия\nМинимум вашего времени\nОдин годовой договор", 'en' => "Ongoing maintenance of your digital presence\nMinimal time required from you\nOne annual contract"],
                        ],
                    ]),
                    'help_title' => ['hy' => 'Չգիտե՞ք որ փաթեթն է ձեզ համար', 'ru' => 'Не знаете, какой пакет выбрать?', 'en' => 'Not sure which package fits?'],
                    'help_lead' => ['hy' => 'Պատմեք, թե որ փուլում է ձեր բիզնեսը, և մենք կառաջարկենք համապատասխանը։', 'ru' => 'Расскажите, на каком этапе ваш бизнес, и мы порекомендуем подходящий.', 'en' => 'Tell us where your business is today and we will recommend one.'],
                ],
            ],
            'portfolio-page' => [
                'title' => ['hy' => 'Պորտֆոլիո', 'ru' => 'Портфолио', 'en' => 'Portfolio'],
                'meta_title' => ['hy' => 'Պորտֆոլիո', 'ru' => 'Портфолио', 'en' => 'Portfolio'],
                'meta_description' => ['hy' => 'I MUST թիմի նախագծերը՝ կայքեր, սոցցանցեր, վիդեո, գովազդ և բրենդինգ։', 'ru' => 'Проекты команды I MUST: сайты, соцсети, видео, реклама и брендинг.', 'en' => 'Websites, social media, video, advertising and branding projects by the I MUST team.'],
                'attributes' => [
                    'hero_eyebrow' => ['hy' => 'Պորտֆոլիո', 'ru' => 'Портфолио', 'en' => 'Portfolio'],
                    'hero_title' => ['hy' => 'Աշխատանքներ մեր հաճախորդների համար', 'ru' => 'Работы для наших клиентов', 'en' => 'Work we have done for our clients'],
                    'hero_lead' => ['hy' => 'Կայքեր, սոցցանցեր, վիդեո, գովազդ և բրենդինգ։ Ընտրեք ծառայությունը և տեսեք համապատասխան նախագծերը։', 'ru' => 'Сайты, соцсети, видео, реклама и брендинг. Выберите услугу, чтобы увидеть проекты по ней.', 'en' => 'Websites, social media, video, ads and branding. Pick a service to see the projects behind it.'],
                    'cta_title' => ['hy' => 'Ուզո՞ւմ եք նման արդյունքներ։', 'ru' => 'Хотите таких же результатов?', 'en' => 'Want results like these?'],
                    'cta_lead' => ['hy' => 'Պատմեք ձեր նախագծի մասին, և մենք կառաջարկենք համապատասխան փաթեթը։', 'ru' => 'Расскажите о своём проекте, и мы предложим подходящий пакет.', 'en' => 'Tell us about your project and we will suggest the package that fits.'],
                ],
            ],
            'studio-page' => [
                'title' => ['hy' => 'Ստուդիա', 'ru' => 'Студия', 'en' => 'Studio'],
                'meta_title' => ['hy' => 'I MUST Studio', 'ru' => 'Студия I MUST', 'en' => 'I MUST Studio'],
                'meta_description' => ['hy' => 'I MUST-ի երկրորդ փուլը՝ կրթական ծրագրեր, կոնֆերանս սրահ, ֆոտոզոնաներով ստուդիայի վարձույթ և սեփական արտադրություն։', 'ru' => 'Второй этап I MUST: образовательные программы, конференц-зал, аренда студии с фотозонами и собственный продакшн.', 'en' => 'Phase two of I MUST: educational programs, a conference hall, studio rentals with photo zones and in-house production.'],
                'attributes' => [
                    'hero_eyebrow' => ['hy' => 'Երկրորդ փուլ', 'ru' => 'Второй этап', 'en' => 'Phase two'],
                    'hero_title' => ['hy' => 'I MUST Studio', 'ru' => 'Студия I MUST', 'en' => 'The I MUST Studio'],
                    'hero_lead' => ['hy' => 'Տարածք ուսուցման, միջոցառումների և արտադրության համար։ I MUST-ի զարգացման հաջորդ փուլը։', 'ru' => 'Пространство для обучения, мероприятий и продакшна. Следующий этап развития I MUST.', 'en' => 'A space for learning, events and production, opening as the next stage of I MUST.'],
                    'hero_image' => $this->image('site/studio-hero.webp'),
                    'hero_image_alt' => ['hy' => 'Ստուդիա՝ լուսավորման սարքավորումներով', 'ru' => 'Студия с осветительным оборудованием', 'en' => 'Studio space with lighting equipment'],
                    'offerings' => $this->flexible('offering', [
                        [
                            'title' => ['hy' => 'Կրթական ծրագրեր', 'ru' => 'Образовательные программы', 'en' => 'Educational programs'],
                            'text' => ['hy' => 'Դասընթացներ և վորքշոփներ մարքեթինգի, բովանդակության և թվային հմտությունների մասին։', 'ru' => 'Курсы и воркшопы по маркетингу, контенту и цифровым навыкам.', 'en' => 'Courses and workshops on marketing, content and digital skills.'],
                            'image' => $this->image('site/studio-education.webp'),
                            'image_alt' => ['hy' => 'Վորքշոփ լսարանում', 'ru' => 'Воркшоп в учебном классе', 'en' => 'Workshop in a classroom'],
                        ],
                        [
                            'title' => ['hy' => 'Կոնֆերանս սրահ', 'ru' => 'Конференц-зал', 'en' => 'Conference hall'],
                            'text' => ['hy' => 'Սրահ շնորհանդեսների, միջոցառումների և հանդիպումների համար։', 'ru' => 'Зал для презентаций, мероприятий и встреч.', 'en' => 'A hall for presentations, events and meetups.'],
                            'image' => $this->image('site/studio-hall.webp'),
                            'image_alt' => ['hy' => 'Կոնֆերանս սրահ՝ նստատեղերի շարքերով', 'ru' => 'Конференц-зал с рядами кресел', 'en' => 'Conference hall with rows of seats'],
                        ],
                        [
                            'title' => ['hy' => 'Ստուդիայի վարձույթ ֆոտոզոնաներով', 'ru' => 'Аренда студии с фотозонами', 'en' => 'Studio rental with photo zones'],
                            'text' => ['hy' => 'Ամրագրեք ստուդիան՝ պատրաստի ֆոտոզոնաներով ձեր նկարահանման համար։', 'ru' => 'Бронируйте студию с готовыми фотозонами для съёмки.', 'en' => 'Book the studio with ready-made photo zones for your shoot.'],
                            'image' => $this->image('site/studio-photozone.webp'),
                            'image_alt' => ['hy' => 'Ֆոտոզոնա՝ ֆոնով', 'ru' => 'Фотозона с фоном', 'en' => 'Photo zone with a backdrop'],
                        ],
                        [
                            'title' => ['hy' => 'Սեփական արտադրություն', 'ru' => 'Собственный продакшн', 'en' => 'In-house production'],
                            'text' => ['hy' => 'Լուսանկարչական և վիդեո արտադրություն՝ մեր թիմի ուժերով։', 'ru' => 'Фото- и видеопроизводство силами нашей команды.', 'en' => 'Photo and video production handled by our own team.'],
                            'image' => $this->image('site/studio-production.webp'),
                            'image_alt' => ['hy' => 'Օպերատորը նկարահանման ժամանակ', 'ru' => 'Оператор во время съёмки', 'en' => 'Camera operator filming'],
                        ],
                    ]),
                    'cta_title' => ['hy' => 'Հետաքրքրե՞ց ստուդիան', 'ru' => 'Интересует студия?', 'en' => 'Interested in the studio?'],
                    'cta_lead' => ['hy' => 'Կապվեք մեզ հետ՝ առաջինը իմանալու ամրագրումների բացման մասին։', 'ru' => 'Свяжитесь с нами, чтобы первыми узнать об открытии бронирования.', 'en' => 'Contact us to hear first when bookings open.'],
                ],
            ],
            'blog-page' => [
                'title' => ['hy' => 'Բլոգ', 'ru' => 'Блог', 'en' => 'Blog'],
                'meta_title' => ['hy' => 'Բլոգ', 'ru' => 'Блог', 'en' => 'Blog'],
                'meta_description' => ['hy' => 'I MUST թիմի գործնական նշումներ կայքերի, սոցցանցերի, վիդեոյի և տեղային որոնման մասին։', 'ru' => 'Практические заметки команды I MUST о сайтах, соцсетях, видео и локальном поиске.', 'en' => 'Practical notes from the I MUST team on websites, social media, video and local search.'],
                'attributes' => [
                    'hero_eyebrow' => ['hy' => 'Բլոգ', 'ru' => 'Блог', 'en' => 'Blog'],
                    'hero_title' => ['hy' => 'Նշումներ թիմից', 'ru' => 'Заметки команды', 'en' => 'Notes from the team'],
                    'hero_lead' => ['hy' => 'Գործնական խորհուրդներ կայքերի, սոցցանցերի, վիդեոյի և տեղային որոնման մասին՝ այդ աշխատանքն անող մարդկանցից։', 'ru' => 'Практические советы о сайтах, соцсетях, видео и локальном поиске от людей, которые делают эту работу.', 'en' => 'Practical advice on websites, social media, video and local search, from the people who do the work.'],
                    'cta_title' => ['hy' => 'Պատմեք մեզ ձեր բիզնեսի մասին։', 'ru' => 'Расскажите нам о своём бизнесе.', 'en' => 'Tell us about your business.'],
                    'cta_lead' => ['hy' => 'Մենք կառաջարկենք այն փաթեթը, որը համապատասխանում է ձեր այսօրվա փուլին։', 'ru' => 'Мы предложим пакет, который подходит вашему этапу.', 'en' => 'We will suggest the package that fits where you are today.'],
                ],
            ],
            'contact-page' => [
                'title' => ['hy' => 'Կապվել մեզ հետ', 'ru' => 'Связаться', 'en' => 'Contact us'],
                'meta_title' => ['hy' => 'Կապ I MUST-ի հետ', 'ru' => 'Контакты I MUST', 'en' => 'Contact I MUST'],
                'meta_description' => ['hy' => 'Այցելեք I MUST-ի գրասենյակ Ավանում, Երևան, կամ գրեք մեզ։', 'ru' => 'Приходите в офис I MUST в Аване, Ереван, или напишите нам.', 'en' => 'Visit the I MUST office in Avan, Yerevan, or send us a message.'],
                'attributes' => [
                    'hero_title' => ['hy' => 'Եկեք խոսենք ձեր բիզնեսի մասին։', 'ru' => 'Давайте поговорим о вашем бизнесе.', 'en' => 'Let\'s talk about your business.'],
                    'hero_lead' => ['hy' => 'Այցելեք մեր գրասենյակ Ավանում կամ գրեք մեզ։', 'ru' => 'Приходите в наш офис в Аване или напишите нам.', 'en' => 'Visit our office in Avan or send us a message.'],
                    'office_image' => $this->image('site/contact-office.webp'),
                    'office_image_alt' => ['hy' => 'I MUST-ի գրասենյակի մուտքը', 'ru' => 'Вход в офис I MUST', 'en' => 'The I MUST office entrance'],
                    'office_lines' => ['hy' => "Առաջին հարկ\nԱռանձին մուտք\nԲակ", 'ru' => "Первый этаж\nОтдельный вход\nДвор", 'en' => "First floor\nSeparate entrance\nYard"],
                ],
            ],
        ];
    }
}
