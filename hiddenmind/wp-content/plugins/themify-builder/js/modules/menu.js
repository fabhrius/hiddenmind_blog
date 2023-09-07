/**
 * menu module
 */

(($, Themify, doc)=>{
    'use strict';

    const style_url = ThemifyBuilderModuleJs.cssUrl + 'menu_styles/',
            overlay = doc.createElement('div'),
            isActive = Themify.is_builder_active,
            loadMobileCss = ()=> {
                return Themify.loadCss(style_url + 'mobile');
            },
            toggleCallback = (link, icon)=>{
                link.closest( 'li' ).classList.toggle( 'tb_menu_open' );
				$( link ).next().slideToggle();
            },
            closeMenu = ()=> {
                overlay.classList.remove('body-overlay-on');
                doc.body.classList.remove('menu-module-left','menu-module-right');
                const mobile_menu = $('.mobile-menu-module.visible').removeClass('left right');
                setTimeout(()=>{
                    mobile_menu.removeClass('visible');
                }, 300);
            },
            init = (isResize, items, windowWidth)=> {
                for (let i = items.length - 1; i > -1; --i) {
                    let item=items[i],
                        breakpoint = parseInt(item.dataset.menuBreakpoint),
                        tmp = item.tfClass('nav')[0];
					if ( item.tfClass( 'tb_mega_menu' )[0] ) {
						Themify.loadCss( style_url + 'mega', 'tb_menu_mega' );
						Themify.megaMenu( item );
					}
                    if (item.classList.contains('dropdown')) {
                        Themify.loadCss(style_url + 'dropdown','tb_menu_dropdown');
                    }
                    if (tmp) {
                        if (tmp.classList.contains('transparent')) {
                            Themify.loadCss(style_url + 'transparent','tb_menu_transparent');
                        }
                        let type = tmp.classList.contains('fullwidth') ? 'fullwidth' : (tmp.classList.contains('vertical') ? 'vertical' : '');
                        if (type !== '') {
                            Themify.loadCss(style_url + type,'tb_menu_' + type);
                            if ('vertical' === type && !item.tfClass('tf_acc_menu')[0]) {
                                Themify.loadCss(style_url + 'accordion','tb_menu_accordion');
                            }
                        }
                    }
                    if (breakpoint > 0) {
                        item.classList.toggle('module-menu-mobile-active',windowWidth < breakpoint);
                    }
                    
                    if (item.tfClass('tf_acc_menu')[0]===undefined) {
                        setTimeout(()=> {
                            Themify.edgeMenu(item);
                        }, 1500);
                    }
                }
                if (!isActive) {
                    if (isResize === false) {
                        let menuBurger = $('.menu-module-burger'),
                                breakpoint = menuBurger.parent().data('menu-breakpoint'),
                                style = menuBurger.parent().data('menu-style');
                        if (style === 'mobile-menu-dropdown' && menuBurger.length && windowWidth < breakpoint) {
                            doc.body.tfOn('click',e=> {
                                const menuContainer = $('.module-menu-container');
                                if (!e.target.closest('.module-menu-container,.menu-module-burger') && menuContainer.is(':visible')  && menuBurger.is(':visible')) {
                                    menuBurger.removeClass('is-open');
                                    menuContainer.removeClass('is-open');
                                }
                            });
                        }
                    } else {
                        closeMenu();
                    }
                }
            };
    Themify.on('builder_load_module_partial', (el,isLazy)=>{
        if(isLazy===true && !el.classList.contains('module-menu')){
            return;
        }
        const items = Themify.selectWithParent('module-menu',el);
        init(false, items, Themify.w);
    });
    if (!isActive) {
        const builder = doc.createElement('div'),
                link = doc.createElement('link'),
                isMin=Themify.is_min===true?'.min':'';
        let href=style_url + 'mobile'+isMin+'.css?ver='+Themify.v;
        if(Themify.urlArgs!==null){
            href+=Themify.urlArgs;
        }
        link.rel = 'prefetch';
        link.setAttribute('as', 'style');
        link.href = href;
        builder.className = 'themify_builder';
        overlay.classList.add('body-overlay');
        builder.appendChild(overlay);
        doc.body.append(builder,link);
        Themify.body.on('click', '.menu-module-burger', function (e) {
            e.preventDefault();
            loadMobileCss().then(()=> {
                const $parent = $(this).parent(),
                        elStyle = $parent.data('menu-style');
                if (elStyle === 'mobile-menu-dropdown') {
                    $(this).toggleClass('is-open').siblings('.module-menu-container').toggleClass('is-open');
                    return;
                }

                const menuDirection = $parent.data('menu-direction'),
                        elID = $parent.data('element-id'),
                        builderID = builder.dataset.id,
                        newBuilderID = $parent[0].closest('.themify_builder_content').dataset.postid;
                if (!builderID || newBuilderID !== builderID) {
                    if (builderID) {
                        builder.classList.remove('themify_builder_content-' + builderID);
                    }
                    builder.dataset.id = newBuilderID;
                    builder.className += ' themify_builder_content-' + newBuilderID;
                }
                let mobile_menu = $('div[data-module="' + elID + '"]', builder);
                if (!mobile_menu.length) {
                    let gs = $parent.data('gs'),
                            menuContent = $parent.find('div[class*="-container"] > ul').clone(),
                            menuUI = menuContent.prop('class').replace(/nav|menu-bar|fullwidth|vertical|with-sub-arrow/g, ''),
                            customStyle = $parent.prop('class').match(/menu-[\d\-]+/g);

                    gs = !gs ? '' : ' ' + gs;
                    customStyle = customStyle ? customStyle[0] : '';
                    mobile_menu = $('<div/>');
                    mobile_menu.addClass('mobile-menu-module ' + ' ' + menuUI + ' ' + customStyle + ' ' + elID + ' ' + elStyle + gs + ' module-menu')
                            .attr('data-module', elID)
                            .attr('data-dir', menuDirection)
                            .appendTo(builder);

                    menuContent = menuContent.removeAttr('id').removeAttr('class').addClass('nav');
                    if (menuContent.find('.sub-menu').length) {
                        menuContent.find('.sub-menu').prev('a').append('<i class="toggle-menu"></i>');
                    }
                    Themify.lazyScroll(menuContent[0].querySelectorAll('[data-lazy]'), true);
                    mobile_menu
                            .html(menuContent)
                            .prepend('<a class="menu-close" href="#"><span class="menu-close-inner tf_close"></span><span class="screen-reader-text">&times</span></a>');
                }
				doc.body.classList.add('menu-module-' + menuDirection);
                mobile_menu.addClass('visible');
                setTimeout( ()=> {
                    mobile_menu.addClass(menuDirection);
                }, 50); // small delay for CSS transition to take effect

                overlay.classList.add('body-overlay-on');
            });
        })
                .on('click', '.mobile-menu-module ul .toggle-menu', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    loadMobileCss().then(()=>{
                        toggleCallback(this.closest('a'),this);
                    });
                }).on('click', '.mobile-menu-module ul a[href="#"]', function (e) {
            e.preventDefault();
            const linkIcon = this.querySelector('.toggle-menu');
            if (linkIcon !== null) {
                loadMobileCss().then(()=>{
                    toggleCallback(this, linkIcon);
                });
            }
        })
                .on('click', '.themify_builder .body-overlay,.mobile-menu-module .menu-close,.mobile-menu-module .menu-item a', e=>{
                    const target = e.target;
                    if (target.classList.contains('toggle-menu') || (target.tagName==='A' && target.getAttribute('href') === '#')) {
                        return;
                    }
                    if (target.classList.contains('menu-close-inner') || (target.parentNode.classList.contains('menu-close'))) {
                        e.preventDefault();
                    }
                    loadMobileCss().then(closeMenu);
                });
    }

    Themify.on('tfsmartresize', e=>{
        if (e) {
            init(true, doc.querySelectorAll('.module-menu.module'), e.w);
        }
    });

})(jQuery, Themify, document);
