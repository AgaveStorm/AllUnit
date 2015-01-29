<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkSelectIdControl">
        <xsl:variable name="value" select="params/value"/>
        <select name="{params/name}">
            <xsl:choose>
                <xsl:when test="params/multiid = 'multiid'">
                    <xsl:attribute name="class">multiselect</xsl:attribute>
                    <xsl:attribute name="name">
                        <xsl:value-of select="params/name"/>[]
                    </xsl:attribute>
                    <xsl:attribute name="multiple">yes</xsl:attribute>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:attribute name="class">singleselect</xsl:attribute>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:for-each select="items/item">
                <xsl:variable name="id" select="id"/>
                <option value="{id}">
                    <xsl:if test="($value = $id)or($value[item=$id])">
                        <xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    <xsl:value-of select="title"/>
                </option>
            </xsl:for-each>
        </select>
    </xsl:template>
</xsl:stylesheet>
