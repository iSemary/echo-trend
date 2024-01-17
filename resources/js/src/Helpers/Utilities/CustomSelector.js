import React from "react";
import Select from "react-select";
import makeAnimated from "react-select/animated";
import styleVariables from "../../assets/styles/variables/variables.module.scss";

const CustomSelector = ({
    options,
    placeholder,
    onChange,
    isMulti,
    labelKey = "title",
    valueKey = "id",
    defaultSelectedValues = [],
}) => {
    // Select2 animation on select
    const animatedComponents = makeAnimated();
    // Initializes the default selected options based on provided default values.
    // Filters options to include only those whose valueKey is present in the defaultSelectedValues array.
    const defaultSelectedOptions = defaultSelectedValues
        ? options.filter((option) =>
              defaultSelectedValues.includes(option[valueKey])
          )
        : [];

    return (
        <Select
            closeMenuOnSelect={isMulti ? false : true}
            placeholder={placeholder}
            onChange={onChange}
            components={animatedComponents}
            isMulti={isMulti ? true : false}
            getOptionLabel={(option) => `${option[labelKey]}`}
            getOptionValue={(option) => `${option[valueKey]}`}
            options={options}
            value={defaultSelectedOptions}
            theme={(theme) => ({
                ...theme,
                colors: {
                    ...theme.colors,
                    primary25: styleVariables.primaryColor,
                    primary: styleVariables.primaryColor,
                    neutral0: styleVariables.darkGrayColor,
                    neutral10: styleVariables.primaryColor,
                    neutral80: styleVariables.whiteColor,
                },
            })}
        />
    );
};

export default CustomSelector;
