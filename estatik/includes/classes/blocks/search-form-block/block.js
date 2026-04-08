(function (blocks, editor, element, components) {
    const { createElement: el, useState, Fragment } = element;
    const { useBlockProps, InspectorControls } = editor;
    const {
        PanelBody,
        TextControl,
        SelectControl,
        CheckboxControl,
        ColorPicker,
        FormTokenField,
        ToggleControl,
        TabPanel,
        Button,
    } = components;

    const { attributes, fields, blockName, taxonomies } = window.ES_BLOCK_SEARCH_FORM;

    const FIELD_OPTIONS = Object.keys(fields || {}).map((value) => ({
        value,
        label: fields[value],
    }));

    const TAXONOMIES = Object.keys(taxonomies || {}).map((value) => ({
        value: taxonomies[value],
        label: taxonomies[value],
    }));

    const FIELD_LABELS = FIELD_OPTIONS.map((o) => o.label);

    const FIELD_VALUE_BY_LABEL = FIELD_OPTIONS.reduce((acc, item) => {
        acc[item.label] = item.value;
        return acc;
    }, {});

    blocks.registerBlockType(blockName, {
        title: "Search Form",
        icon: {
            src: "search",
            foreground: "#40916c",
        },
        category: "es-blocks",
        attributes,

        edit(props) {
            const { attributes: attrs, setAttributes } = props;
            const isSimpleMode = attrs.search_type === "simple" || attrs.search_type === "main";
            const isAdvancedMode = attrs.search_type === "advanced";

            const queryAtts = attrs.query_atts || {};
            const queryKeys = Object.keys(queryAtts);
            const activeKey = attrs.active_query_key || queryKeys[0] || "";
            const activeValue = activeKey ? queryAtts[activeKey] : "";

            const blockProps = useBlockProps({
                style: {
                    border: "1px solid #b7e4c7",
                    borderRadius: "8px",
                    padding: attrs.padding || "20px",
                },
            });

            return el(
                "div",
                blockProps,

                el(
                    InspectorControls,
                    {},

                    /* =========================
                     * General
                     * ========================= */

                    el(
                        PanelBody,
                        { title: "General", className: "es-block-panel es-search-form-panel", initialOpen: false },

                        el(SelectControl, {
                            label: "Search Type",
                            value: attrs.search_type,
                            options: [
                                { label: "Main", value: "main" },
                                { label: "Simple", value: "simple" },
                                { label: "Advanced", value: "advanced" },
                            ],
                            onChange: (val) => setAttributes({ search_type: val }),
                        }),

                        el(TextControl, {
                            label: "Search Title",
                            value: attrs.title,
                            onChange: (val) => setAttributes({ title: val }),
                        }),

                        el(TextControl, {
                            label: "Search Page ID",
                            value: attrs.search_page_id,
                            onChange: (val) => setAttributes({ search_page_id: val }),
                        })
                    ),

                    /* =========================
                     * Behaviour
                     * ========================= */
                    el(
                        PanelBody,
                        { title: "Behaviour", className: "es-block-panel es-search-form-panel", initialOpen: false },

                        el(ToggleControl, {
                            label: "Enable Address Search",
                            checked: attrs.is_address_search_enabled,
                            onChange: (val) => setAttributes({ is_address_search_enabled: val }),
                        }),

                        el(ToggleControl, {
                            label: "Enable Main Filter",
                            checked: attrs.is_main_filter_enabled,
                            onChange: (val) => setAttributes({ is_main_filter_enabled: val }),
                        }),

                        el(ToggleControl, {
                            label: "Enable Collapsed Filter",
                            checked: attrs.is_collapsed_filter_enabled,
                            onChange: (val) => setAttributes({ is_collapsed_filter_enabled: val }),
                        }),

                        el(ToggleControl, {
                            label: "Enable AJAX",
                            checked: attrs.enable_ajax,
                            onChange: (val) => setAttributes({ enable_ajax: val }),
                        }),

                        el(ToggleControl, {
                            label: "Enable Saved Search",
                            checked: attrs.enable_saved_search,
                            onChange: (val) => setAttributes({ enable_saved_search: val }),
                        })
                    ),

                    /* =========================
                     * Fields
                     * ========================= */
                    el(
                        PanelBody,
                        {
                            title: "Fields",
                            className: "es-block-panel es-search-form-panel es-block-panel--fields",
                            initialOpen: true,
                        },

                        isSimpleMode &&
                            el(FormTokenField, {
                                label: "Main Fields",
                                value: attrs.main_fields
                                    ? attrs.main_fields
                                          .split(",")
                                          .map((slug) => fields[slug])
                                          .filter(Boolean)
                                    : [],
                                suggestions: FIELD_LABELS,
                                __experimentalExpandOnFocus: true,
                                onChange: (labels) => {
                                    const values = labels.map((label) => FIELD_VALUE_BY_LABEL[label]).filter(Boolean);
                                    setAttributes({ main_fields: values.join(",") });
                                },
                            }),

                        isSimpleMode &&
                            el(FormTokenField, {
                                label: "Collapsed Fields",
                                value: attrs.collapsed_fields
                                    ? attrs.collapsed_fields
                                          .split(",")
                                          .map((slug) => fields[slug])
                                          .filter(Boolean)
                                    : [],
                                suggestions: FIELD_LABELS,
                                __experimentalExpandOnFocus: true,
                                onChange: (labels) => {
                                    const values = labels.map((label) => FIELD_VALUE_BY_LABEL[label]).filter(Boolean);
                                    setAttributes({ collapsed_fields: values.join(",") });
                                },
                            }),

                        isAdvancedMode &&
                            el(FormTokenField, {
                                label: "All Fields",
                                value: attrs.fields
                                    ? attrs.fields
                                          .split(",")
                                          .map((slug) => fields[slug])
                                          .filter(Boolean)
                                    : [],
                                suggestions: FIELD_LABELS,
                                __experimentalExpandOnFocus: true,
                                onChange: (labels) => {
                                    const values = labels.map((label) => FIELD_VALUE_BY_LABEL[label]).filter(Boolean);
                                    setAttributes({ fields: values.join(",") });
                                },
                            })
                    ),

                    /* =========================
                     * Query Filters (REPEATER)
                     * ========================= */
                    el(
                        PanelBody,
                        { title: "Query Filters", className: "es-block-panel es-search-form-panel", initialOpen: false },

                        queryKeys.length > 0 &&
                            el(
                                "div",
                                { className: "es-query-filters-list" },
                                queryKeys.map((key) =>
                                    el(
                                        "button",
                                        {
                                            key,
                                            className:
                                                "components-button is-secondary" +
                                                (key === activeKey ? " is-primary" : ""),
                                            onClick: () => setAttributes({ active_query_key: key }),
                                        },
                                        `${key}: ${queryAtts[key]}`
                                    )
                                )
                            ),

                        el(SelectControl, {
                            label: "Field",
                            value: activeKey,
                            options: [{ label: "— Select field —", value: "" }, ...TAXONOMIES],
                            onChange: (val) => {
                                if (!val) return;

                                const next = { ...queryAtts };

                                if (activeKey && activeKey !== val) {
                                    next[val] = next[activeKey];
                                    delete next[activeKey];
                                } else {
                                    next[val] = "";
                                }

                                setAttributes({
                                    query_atts: next,
                                    active_query_key: val,
                                });
                            },
                        }),

                        el(TextControl, {
                            label: "Custom field",
                            placeholder: "e.g. type, status, meta_key",
                            value: activeKey && !FIELD_OPTIONS.find((o) => o.value === activeKey) ? activeKey : "",
                            onChange: (val) => {
                                if (!val) return;

                                const next = { ...queryAtts };

                                // rename existing key
                                if (activeKey && activeKey !== val) {
                                    next[val] = next[activeKey];
                                    delete next[activeKey];
                                } else if (!activeKey) {
                                    next[val] = "";
                                }

                                setAttributes({
                                    query_atts: next,
                                    active_query_key: val,
                                });
                            },
                        }),

                        activeKey &&
                            el(TextControl, {
                                label: "Value",
                                value: activeValue,
                                onChange: (val) =>
                                    setAttributes({
                                        query_atts: {
                                            ...queryAtts,
                                            [activeKey]: val,
                                        },
                                    }),
                            }),

                        el(
                            "button",
                            {
                                className: "components-button is-secondary",
                                onClick: () => {
                                    let i = 1;
                                    let key = "custom_field";

                                    while (queryAtts[key]) {
                                        i++;
                                        key = `custom_field_${i}`;
                                    }

                                    setAttributes({
                                        query_atts: {
                                            ...queryAtts,
                                            [key]: "",
                                        },
                                        active_query_key: key,
                                    });
                                },
                            },
                            "+ Add filter"
                        ),

                        activeKey &&
                            el(
                                "button",
                                {
                                    className: "components-button is-link is-destructive",
                                    onClick: () => {
                                        const next = { ...queryAtts };
                                        delete next[activeKey];

                                        setAttributes({
                                            query_atts: next,
                                            active_query_key: "",
                                        });
                                    },
                                },
                                "Remove filter"
                            )
                    ),

                    /* =========================
                     * Appearance
                     * ========================= */

                    el(
                        PanelBody,
                        { title: "Appearance", className: "es-block-panel es-search-form-panel", initialOpen: false },

                        el(ColorPicker, {
                            color: attrs.background || "#ffffff",
                            onChangeComplete: (value) => {
                                setAttributes({ background: value.hex });
                            },
                            disableAlpha: true
                        })
                    ),
                ),

                el("strong", {}, attrs.title || "Search Form"),
                el(
                    "p",
                    { style: { marginTop: "6px", opacity: 0.65 } },
                    "Editor preview. Final output is rendered on the frontend."
                )
            );
        },

        save() {
            return null;
        },
    });
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.components);
